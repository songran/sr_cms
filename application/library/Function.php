<?php



function echojson($arr)
{
    echo json_encode($arr);
}

//分页方法
function page($url,$page,$count,$offset = 20,$status='')
{
    $allpage = ceil($count/$offset);        //总页数

    if($status)
    {
        $status ='&'.$status;
    }

    $first = "<a href='".$url.'?page=1'.$status."'>首页</a>";
    $last = "<a href='".$url.'?page='.$allpage.$status."'>末页</a>";
    if($page > 1)
    {
        $shangyiye = "&nbsp;<a href='".$url.'?page='.($page-1).$status."'>上一页</a>&nbsp;";
    }
    else
    {
        $shangyiye = '&nbsp;&nbsp;';
    }
    if($page < $allpage)
    {
        $xiayiye = "&nbsp;<a href='".$url.'?page='.($page+1).$status."'>下一页</a>&nbsp;";
    }
    else
    {
        $xiayiye = '&nbsp;&nbsp;';
    }
    $page = "当前 第<span style='color:gray'>{$page}</span>&nbsp;页";

    $all = "共 ".$count." 篇&nbsp;&nbsp;共 ".$allpage." 页&nbsp;&nbsp;&nbsp;&nbsp";
    $html = $all.$first.$shangyiye.$page.$xiayiye.$last;
    return $html;
}
 /**
     * api接口统一输出格式
     * @author czz 2018/7/4 17:48
     * @param int $code
     * @param string $msg
     * @param array $data
     */
 function returnJson($code,$msg,array $data=[]){
    $response = [
        'code' => $code,
        'msg' => $msg,
    ];
    $data ? $response['data'] = $data : '';
    $modA = new CJSON();
    $out = $modA::encode($response);
    echo  $out;
    exit;
}
/**
 * 无限极分类
 * @Author   SongRan
 * @DateTime 2024-01-24
 */
function getTree($items,$id='id',$pid='pid',$son = 'children')
{
      $tree   = array(); //格式化的树
      $tmpMap = array(); //临时扁平数据
        
      foreach ($items as $item) {
        $tmpMap[$item[$id]] = $item;
       // $tmpMap[$item[$id]][$son] =[]; 
      }    
      foreach ($items as $item) {
        if (isset($tmpMap[$item[$pid]])) {
          $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
        } else {
          $tree[] = &$tmpMap[$item[$id]];
        }
      }
      unset($tmpMap);
      return $tree;
}
/**
 * 获取当前登陆状态
 * @return bool
 */
function loginstatus()
{
    $session = Yaf_Session::getInstance();
    if($session->admin)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function txtlog($name,$str)
{
    $handle = fopen("log.txt","a+");
    fwrite($handle,$name."\n");
    fwrite($handle,$str."\n\n");
    fclose($handle);
}

//返回性别 1男 2女 其他未知
function getSex($sex=0)
{
    switch ($sex) {
        case 1:
            $name = '男';
            break;
        case 2:
            $name = '女';
            break;     
        default:
            $name ='未知';
            break;
    }
    return $name;
}

//生成缓存key
function cachekey($functionname,$parm = '')
{
    if($parm)
    {
        if(is_array($parm))
        {
            $tail = '';
            foreach($parm as $value)
            {
                $tail .= "_".$value;
            }
            $key = $functionname.$tail;
        }
        else
        {
            $key = $functionname.'_'.$parm;
        }
    }
    else
    {
        $key = $functionname;
    }
    return $key;
}

//生成小图片的url    /upload/20150506/aaa.jpg=>/upload/20150506/small_aaa.jpg
//如果中图不存在，则返回原图
function resizeimgurl($url,$ext = 'small')
{
    $info = pathinfo($url);
    $name = "/".$ext."_".$info['basename'];
    if($ext == 'middle')
    {

        $dir = str_replace(BASE_URL,"./",$info['dirname'].$name);
        if(!file_exists($dir))
        {
            return $url;
        }
    }
    return $info['dirname'].$name;
}

//字符串截取
function cutstr($string, $sublen, $start = 0, $code = 'UTF-8')
{
    if($code == 'UTF-8')
    {
        $pa ="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string); if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else
    {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = ''; for($i=0; $i<$strlen; $i++)
    {
        if($i>=$start && $i<($start+$sublen))
        {
            if(ord(substr($string, $i, 1))>129)
            {
                $tmpstr.= substr($string, $i, 2);
            }
            else
            {
                $tmpstr.= substr($string, $i, 1);
            }
        }
        if(ord(substr($string, $i, 1))>129) $i++;
    }
        if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}