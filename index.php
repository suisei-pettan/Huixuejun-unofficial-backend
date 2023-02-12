<?php
//获取url中的参数

//192.168.2.210改为你的alist主机地址

$query_str = $_SERVER['QUERY_STRING'];

// parse_str($query_str); /* 这种方式可以直接使用变量$id, $category, $title */
ob_start();
parse_str($query_str, $query_arr);
$mode = $query_arr['service'];
//$file_type = $query_arr['taskid'];
$task_id = array();
$task_id_len = 0;

function get_link($path1)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://192.168.2.210:5244/api/fs/get?path=' . urlencode($path1),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response1 = curl_exec($curl);
    curl_close($curl);
    $response1 = json_decode($response1, true)['data']['raw_url'];
    $response1 = substr($response1, 0, strpos($response1, 'sign') - 1);
    return $response1;
}

function get_file($path)
{
    global $name;
    $file_name = array();
    $res = array();
    $curl = curl_init();
    $lesson = '{"ret": 200,"data": {"list": [';

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://192.168.2.210:5244/api/fs/list',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'path=' . urlencode($path),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $get_folder = curl_exec($curl);
    curl_close($curl);
    $get_folder = json_decode($get_folder, true)['data']['content'];
    $get_folder_len = count((array)$get_folder);
    for ($i = 0; $i < $get_folder_len; $i++) {
        if ($get_folder[$i]['is_dir'] == false) {
            $file_name[$i] = $get_folder[$i]['name'];
            $name[] = $file_name[$i];
            $res[] = get_link($path . '/' . $file_name[$i]);
        }
    }
    $name_len = count((array)$name);
    for ($i = 0; $i < $name_len; $i++) {
        if ($i != $name_len - 1) {
            $lesson = $lesson . '{"id": "关注冰糖io，人生永远得优","task_id": "关注冰糖io，人生永远得优","resource_id": "3240910","uri": "' . $res[$i] . '","title": "' . $name[$i] . '","type": "9","size": "2.27 MB","sources": 1,"delete_flag": "1","is_read": "1","course_id": "","section_id": "","vtype": 0,"isread": 1},';
        } else {
            $lesson = $lesson . '{"id": "关注冰糖io，人生永远得优","task_id": "关注冰糖io，人生永远得优","resource_id": "3240910","uri": "' . $res[$i] . '","title": "' . $name[$i] . '","type": "9","size": "2.27 MB","sources": 1,"delete_flag": "1","is_read": "1","course_id": "","section_id": "","vtype": 0,"isread": 1}],"taskinfo": {"web_taskinfo": "资源：《2.2 二项分布及其应用 》","web_starttime": "2022-04-08 10:14:00","web_endtime": "2022-04-09 10:14:00","web_chaper": "2.2 二项分布及其应用 ","web_taskdesc": "","web_limited_time": "0"},"allread": 1,"costtime": "79"},"msg": ""}';
        }
    }
    exit ($lesson);
}

$Subject = '
{
	"ret": 200,
	"data": [{
		"subjectcd": "410",
		"subjectname": "DD学",
		"stagecd": "4",
		"icon": "http://192.168.2.210/icon.png",
		"icon2": "http://192.168.2.210/icon.png",
		"count": "2"
	}],
	"msg": ""
}
';
if ($mode == "App.Task.GetAfterClass") {
    $datafile = fopen("data.txt", "r") or die("Unable to open file!");
    $Task_head = fread($datafile,filesize("data.txt"));
    fclose($datafile);
    exit($Task_head);
} elseif ($mode == "App.Knowledge.GetSubject") {
    exit($Subject);
} elseif ($mode == "App.Knowledge.GetSourseInfo") {
    $file_type = $query_arr['taskid'];
    get_file($file_type);
} elseif ($mode == "App.Report.GetZongheReport") {
    exit('{"ret":200,"data":"http://192.168.1.77/index.php","msg":""}');
}