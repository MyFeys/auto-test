<?php
namespace AutoTest\Lib;

use AutoTest\Exception\InvalidException;
use Swagger\Serializer;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class SwaggerAnalyze
{
    public $info;
    public $host;
    public $basePath;
    public $schemes;
    public $consumes;
    public $produces;
    public $paths;
    public $definitions;
    public $securityDefinitions;
    public $tagsObject;
    public $tagsArr;
    public $externalDocs;
    public static $methodArr = ['get', 'put', 'post', 'delete', 'options', 'head', 'patch'];
    const UNDEFINED='{SWAGGER-PHP-UNDEFINED-46EC-07AB32D2-D50C}';

    public function __construct($path)
    {
        $swagger = $this->getSwaggerJsonData($path);
        if (empty($swagger)) {
            throw new InvalidException(sprintf('文件格式有误 "%s"', $path));
        }
        $this->setAttribute($swagger);
    }

    public function getSwaggerJsonData($path)
    {
        if (is_file($path)) {
            $json = file_get_contents($path);
        } else {
            $json = $path;
        }
        return (new Serializer())->deserialize($json, 'Swagger\Annotations\Swagger');
    }

    public function setAttribute($swagger)
    {
        $this->info = $swagger->info;
        $this->host = $swagger->host;
        $this->basePath = $swagger->basePath;
        $this->schemes = $swagger->schemes;
        $this->consumes = $swagger->consumes;
        $this->produces = $swagger->produces;
        $this->paths = $swagger->paths;
        $this->paths = $swagger->paths;
        $this->definitions = $swagger->definitions;
        $this->securityDefinitions = $swagger->securityDefinitions;
        $this->tagsObject = $swagger->tags;
        $this->externalDocs = $swagger->externalDocs;
        
        $this->tagsArr = array_map(function($tag) {
            return $tag->name;
        }, $this->tagsObject);
    }
    
    public function getCurrentUrl($uri)
    {
        $schemes = $this->schemes[0];
        return $schemes.'://'.$this->host.$this->basePath.$uri;
    }

    public function getCurrentPathTags($path)
    {
        $data = [];
        foreach (self::$methodArr as $method) {
            if (isset($path->$method->tags)) {
                $data = array_merge($data, $path->$method->tags);
            }
        }

        return $data;
    }


    
    public function getCurrentParams($parameters)
    {
        $params = [];
        if (!empty($parameters)) {
            foreach ($parameters as $parameter) {
                $params = array_merge($params, $this->getParameters($parameter));
            }
        }
        return $params;
    }
    
    private function getParameters($parameter)
    {
        $in = $parameter->in;

        $data = [];
        switch ($in) {
            case 'body':
                if (empty($parameter->schema->ref)) {
                    $data[] = $this->getSchemaData($parameter->schema->items->ref);
                } else {
                    $data = $this->getSchemaData($parameter->schema->ref);
                }
                break;
            case 'query':
                $data = $this->getQueryData($parameter);
                break;
            case 'path':
//                $data = $this->getPathData($parameter); // 未实现
                break;
            case 'formData':
                $data = $this->getFormData($parameter);
                break;
            case 'header':
                break;
            default:
                break;
        }

        return $data;
    }

    private function getSchemaData($ref, $prefix='', &$data = [])
    {
        $ref = explode('/', $ref);
        $ref = end($ref);

        $definition = $this->definitions[$ref];
//        p($definition);

        switch ($definition->type) {
            case 'object':
                foreach ($definition->properties as $property) {

                    if (empty($property->example)) {
                        $property->example = $this->setValue($property->type, $property->required, $property->example, $property->property);
                    }

                    switch ($property->type) {
                        case 'integer':
                        case 'int':
                        case 'string':
                            if (!empty($prefix)) {
                                $data[$prefix][$property->property] = $property->example;
                            } else {
                                $data[$property->property] = $property->example;
                            }
                            break;
                        case 'array':
                            if (!empty($property->items->ref)) {
                                $this->getSchemaData($property->items->ref, $property->property, $data);
                            } else {
                                if (empty($property->example)) {
                                    $property->example = $this->setValue($property->type, $property->required, $property->example, $property->property);
                                }

                                if (!empty($prefix)) {
                                    $data[$prefix][$property->property] = $property->example;
                                } else {
                                    $data[$property->property] = $property->example;
                                }
                            }
                            break;
                        case '':
                        case 'object':
                            if (!empty($property->ref)) {
                                $this->getSchemaData($property->ref, $property->property, $data);
                            } else {
                                if (empty($property->example)) {
                                    $property->example = $this->setValue($property->type, $property->required, $property->example, $property->property);
                                }

                                if (!empty($prefix)) {
                                    $data[$prefix][$property->property] = $property->example;
                                } else {
                                    $data[$property->property] = $property->example;
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }
                break;
            case 'string':
                if (empty($definition->example)) {
                    $definition->example = $this->setValue($definition->type, $definition->required, $definition->example, $prefix);
                }
                $data[$prefix] = $definition->example;
                break;
            case 'array':
                if (empty($definition->items->example)) {
                    $definition->items->example = $this->setValue($definition->items->type, $definition->items->required, $definition->items->example, $definition->property);
                }
                $data[$definition->property] = [$definition->items->example];
                break;
            default:
                break;
        }

        return $data;
    }

    private function getQueryData($parameter)
    {
        $data = [];

       switch ($parameter->type) {
           case 'array':
               $data[$parameter->name] = $parameter->default;
               break;
           case 'string':
               if (!isset($parameter->default) || empty($parameter->default) || $parameter->default=self::UNDEFINED) {
                   $parameter->default = $this->setValue($parameter->type, $parameter->required, '', $parameter->name);
               }
               $data[$parameter->name] = $parameter->default;
               break;
           default:
               break;
       }

        return $data;
    }

    private function getPathData($parameter)
    {
        if (!isset($parameter->default) || empty($parameter->default) || $parameter->default=self::UNDEFINED) {
            $parameter->default = $this->setValue($parameter->type, $parameter->required, '', $parameter->name);
        }

        return [$parameter->name => $parameter->default];
    }

    private function getFormData($parameter)
    {
        if (!isset($parameter->default) || empty($parameter->default) || $parameter->default=self::UNDEFINED) {
            $parameter->default = $this->setValue($parameter->type, $parameter->required, '', $parameter->name);
        }

        return [$parameter->name => $parameter->default];
    }

    /**
     * 返回接口参数
     * @param string $type 参数类型
     * @param bool $required 是否必填字段
     * @param string $default 默认值
     * @return String/Inter
     */
    private function setValue($type, $required, $default, $name)
    {
        // 为了真实非比填写字段随机50%几率为空
        if (empty($required) && rand(0, 1)) {
            return '';
        }

        //有默认值则直接返回默认值
        if ($default != "") {
            return $default;
        }

        switch ($type) {
            case 'string':
                return "Test".$name;
                break;
            case 'integer':
                return rand(1, 10000);
                break;
            case 'array':
                return [rand(1, 10000)];
                break;
        }
    }
}
