<?php 
function createPdfFile($frontData)
{

       // 新建一个pdf文件：

       // Orientation：orientation属性用来设置文档打印格式是“Portrait”还是“Landscape”。 Landscape为横式打印，Portrait为纵向打印

       // Unit：设置页面的单位。pt：点为单位，mm：毫米为单位，cm：厘米为单位，in：英尺为单位

       // Format：设置打印格式，一般设置为A4

       // Unicode：为true，输入的文本为Unicode字符文本

       // Encoding：设置编码格式，默认为utf-8

       // Diskcache：为true，通过使用文件系统的临时缓存数据减少RAM的内存使用。 

       $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT,true, 'UTF-8', false);

       //设置文件信息

       $pdf->SetCreator(PDF_CREATOR);

       $pdf->SetAuthor("jmcx");

       $pdf->SetTitle("pdf test");

       $pdf->SetSubject('TCPDF Tutorial');

       $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

       //删除预定义的打印 页眉/页尾

       $pdf->setPrintHeader(false);

       $pdf->setPrintFooter(false);

       //设置默认等宽字体

       $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

       /*设置页面边幅：

       Left：左边幅

       Top：顶部边幅

       Right：右边幅

       Keepmargins：为true时，覆盖默认的PDF边幅。 */

       $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);

       /*设置单元格的边距：

       Left：左边距

       Top：顶部边距

       Right：右边距

       Bottom：底部边距。*/

       $pdf->setCellPaddings(0, 0, 0, 0);

       //GetX获得当前的横坐标，GetY获得当前的纵坐标。

//       $pdf->GetX();

//       $pdf->GetY();

       /*移动坐标。SetX移动横坐标。 SetY，横坐标自动移动到左边距的距离，然后移动纵坐标。SetXY，移动横坐标跟纵坐标：

       X：横坐标，可设为$pdf->GetX()+数字

       Y：纵坐标，可设为$pdf->GetY()+数字

       Rtloff：true，左上角会一直作为坐标轴的原点

       Resetx：true，重设横坐标。 */

//       $pdf->SetX($x, $rtloff=false);

//       $pdf->SetY($y, $resetx=true, $rtloff=false);

//       $pdf->SetXY($x, $y, $rtloff=false)

       /*设置线条的风格：

       Width：设置线条粗细

       Cap：设置线条的两端形状

       Join：设置线条连接的形状

       Dash：设置虚线模式

       Color：设置线条颜色，一般设置为黑色，如：array(0, 0, 0)。*/

       $pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'color' => array(0, 0,0)));

       // 画一条线：

       // x1：线条起点x坐标

       // y1：线条起点y坐标

       // x2：线条终点x坐标

       // y2：线条终点y坐标

       // style：SetLineStyle的效果一样

       

//       $pdf->Line($x1, $y1, $x2, $y2, $style=array());

       /*执行一个换行符，横坐标自动移动到左边距的距离，纵坐标换到下一行：

       H：设置下行跟上一行的距离，默认的话，高度为最后一个单元格的高度

       Cell：true，添加左或右或上的间距到横坐标。 */

//       $pdf->Ln($h='', $cell=false);

       //设置自动分页符

       $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

       //设置图像比例因子

       $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

       //设置一些语言相关的字符串

//       $pdf->setLanguageArray("xx");

       /*设置字体：

字体类型（如helvetica(Helvetica)黑体，times (Times-Roman)罗马字体）、风格（B粗体，I斜体，underline下划线等）、字体大小 */

       $pdf->SetFont('times', 'I', 20);

       /*增加一个页面:

       Orientation：orientation属性用来设置文档打印格式。 Landscape为横式打印，Portrait为纵向打印。

       Format：设置此页面的打印格式。

       Keepmargins：true，以当前的边幅代替默认边幅来重写页面边幅。

       Tocpage：true，所添加的页面将被用来显示内容表。*/

       $pdf->AddPage();

       /*设置单行单元格：

       W：设置单元格的宽

       H：设置单元格的高

       Text：单元格文本

       Border：设置单元格的边框。0，无边框，1，一个框，L，左边框，R，右边框，B， 底边框，T，顶边框，LTRB指四个边都显示

       Ln：0，单元格后的内容插到表格右边或左边，1，单元格的下一行，2，在单元格下面

       Align：文本位置。L，左对齐，R，右对齐，C，居中，J，自动对齐

       Fill：填充。false，单元格的背景为透明，true，单元格必需被填充

       Link：设置单元格文本的链接。*/

       $pdf->Cell(0, 10, 'test', 1, 1, 'C');

       /*设置多行单元格。注意跟Cell的参数位置有些差别，Cell是用来输出单行文本的，MultiCell就能用来输出多行文本

       W：设置多行单元格的宽

       H： 设置多行单元格的单行的高

       Text：文本

       Border：边框

       Align：文本位置

       Fill：填充

       Ln：0，单元格后的内容插到表格右边或左边，1，单元格的下一行，2，在单元格下面

       X：设置多行单元格的行坐标

       Y：设置多行单元格的纵坐标

       Reseth：true，重新设置最后一行的高度

       Stretch：调整文本宽度适应单元格的宽度

       Ishtml：true，可以输出html文本，有时很有用的

       Autopadding：true，自动调整文本与单元格之间的距离

       Maxh：设置单元格最大的高度

       Valign：设置文本在纵坐标中的位置，T，偏上，M，居中，B，偏下

       Fillcell：自动调整文本字体大小来适应单元格大小。 */

//       $pdf->MultiCell($w, $h, $txt, $border=0, $align='J',$fill=false, $ln=1, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);

       // setCellHeightRatio设置单元格行高，可以引用此函数调整行与行的间距。SetLineWidth设置线条宽度。

//       $pdf->setCellHeightRatio($h);

//       $pdf->SetLineWidth($width);

       /*在PDF中，插入图片，参数列表如下；

       File：图片路径。

       X：左上角或右上角的横坐标。

       Y：左上角或右上角的纵坐标。

       W：设置图片的宽度，为空或为0，则自动计算。

       H：设置图片的高度，为空或为0，则自动计算。

       Type：图片的格式，支持JPGE，PNG，BMP，GIF等，如果没有值，则从文件的扩展名中自动找到文件的格式。

       Link：图片链接。

       Align：图片位置。

       Resize：true，调整图片的大小来适应宽跟高；false，不调整图片大小；2，强制调整。

       Dpi：以多少点每英寸来调整图片大小。

       Palign：图片位置，L，偏左，C，居中，R，偏右

       Imgmask：true，返回图像对象。

       Border：边框。

       Fitbox：调整适合大小。

       Hidden：true，隐藏图片。

       Fitonpage：如果为true，图像调整为不超过页面尺寸。 */

       $pdf->Image('../img/test.png');

       /*输出HTML文本：

       Html：html文本

       Ln：true，在文本的下一行插入新行

       Fill：填充。false，单元格的背景为透明，true，单元格必需被填充

       Reseth：true，重新设置最后一行的高度

       Cell：true，就调整间距为当前的间距

       Align：调整文本位置。 */

      $pdf->writeHTML("<div><label>hah<strong>aha</strong></label><br/></div>");

       /*用此函数可以设置可选边框，背景颜色和HTML文本字符串来输出单元格（矩形区域）

       W：设置单元格宽度。0，伸展到右边幅的距离

       H：设置单元格最小的高度

       X：以左上角为原点的横坐标

       Y：以左上角为原点的纵坐标

       Html：html文本

       Border：边框

       Ln：0，单元格后的内容插到表格右边或左边，1，单元格的下一行，2，在单元格下面

       Fill：填充

       Reseth：true，重新设置最后一行的高度

       Align：文本的位置

       Autopadding：true，自动调整文本到边框的距离。 */

       $pdf->writeHTMLCell();

       /*输入PDF文档 :

       Name：PDF保存的名字

       Dest：PDF输出的方式。I，默认值，在浏览器中打开；D，点击下载按钮， PDF文件会被下载下来；F，文件会被保存在服务器中；S，PDF会以字符串形式输出；E：PDF以邮件的附件输出。 */

       return $pdf->Output("test001.pdf", "F");

}
$a = functioncreatePdfFile();
var_dump($a);