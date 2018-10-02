<?php
namespace moxuandi\phpexcel;

use yii\helpers\ArrayHelper;

/**
 * Class Widget
 * @author  zhangmoxuan <1104984259@qq.com>
 * @link  http://www.zhangmoxuan.com
 * @QQ  1104984259
 * @Date  2018-9-15
 * @see http://phpexcel.codeplex.com/
 * @see https://github.com/moonlandsoft/yii2-phpexcel
 *
 * @property string $format Excel 的版本
 */
class Widget extends \yii\base\Widget
{
    /**
     * @var array 第一行的标题栏, 未设置则使用`$data`子数组里的键名.
     * 每一个键必须是`$data`子数组里的键名.
     * Warning: 第一行有汉字时, 自动计算宽度无效!
     */
    public $headers = [];
    /**
     * @var string|array 工作表的标题. 不能为`null`, `integer`或空字符串.
     */
    public $sheetTitle = 'Worksheet';
    /**
     * @var boolean 是否在一个 Excel 中导出多个工作表.
     * 此属性为`true`时, `$data`应该是一个三维数组, 每个子二维数组表示一个工作表的数据;
     * `$headers`应该是一个二维数组, 每个子数组的键必须是`$data`中子二维数组的键.
     * `$sheetTitle`应该是一个一维数组, 每个元素的键必须是`$data`中子二维数组的键.
     */
    public $isMultipleSheet = false;
    /**
     * @var boolean 是否在第一行设置标题行.
     */
    public $setFirstTitle = true;
    /**
     * @var boolean 是否下载导出结果; 为`false`时仅保存结果到服务器.
     */
    public $asAttachment = true;
    /**
     * @var string 导出的 Excel 文件名.
     */
    public $fileName = 'excel.xls';
    /**
     * @var string 保存到服务器的路径, 仅`asAttachment`为`false`时生效.
     */
    public $savePath = 'uploads/excel/';
    /**
     * @var array Excel 文件的属性列表.
     */
    public $properties = [];


    /**
     * 设置 Excel 文件的属性
     * @param \PHPExcel $objectExcel
     * @param array $properties
     */
    protected function setProperties(&$objectExcel, $properties = [])
    {
        foreach($properties as $key => $value){
            $keyName = 'set' . ucfirst($key);
            $objectExcel->getProperties()->{$keyName}($value);
        }
    }

    /**
     * 获取 Excel 的版本
     * @return string
     */
    protected function getFormat()
    {
        $pathInfo = pathinfo($this->fileName);
        $extensionType = 'Excel2007';
        if(($extension = ArrayHelper::getValue($pathInfo, 'extension')) !== null){
            switch(strtolower($extension)){
                case 'xlsx':			//	Excel (OfficeOpenXML) Spreadsheet
                case 'xlsm':			//	Excel (OfficeOpenXML) Macro Spreadsheet (macros will be discarded)
                case 'xltx':			//	Excel (OfficeOpenXML) Template
                case 'xltm':			//	Excel (OfficeOpenXML) Macro Template (macros will be discarded)
                    $extensionType = 'Excel2007';
                    break;
                case 'xls':				//	Excel (BIFF) Spreadsheet
                case 'xlt':				//	Excel (BIFF) Template
                    $extensionType = 'Excel5';
                    break;
                case 'ods':				//	Open/Libre Offic Calc
                case 'ots':				//	Open/Libre Offic Calc Template
                    $extensionType = 'OOCalc';
                    break;
                case 'slk':
                    $extensionType = 'SYLK';
                    break;
                case 'xml':				//	Excel 2003 SpreadSheetML
                    $extensionType = 'Excel2003XML';
                    break;
                case 'gnumeric':
                    $extensionType = 'Gnumeric';
                    break;
                case 'htm':
                case 'html':
                    $extensionType = 'HTML';
                    break;
                case 'csv':
                    $extensionType = 'CSV';
                    break;
                default:
                    break;
            }
        }
        return $extensionType;
    }
}
