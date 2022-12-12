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
    $response1 = substr($response1,0,strpos($response1,'sign')-1);
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

function get_path($path)
{
    $curl = curl_init();

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
    $get_folder = json_decode($get_folder, true)['data']['content'];
    curl_close($curl);
    return $get_folder;
}

$get_folder_first = true;
function get_folder_path($path)
{
    global $task_id, $task_id_len, $get_folder_first, $page;
    $get_folder = get_path($path);
    $get_folder_len = count((array)$get_folder);

    if ($get_folder_first) {
        $get_folder_first = false;
        array_push($task_id, $path . $get_folder[$page-1]['name']);
//            $get_folder_first = true;
        get_folder_path($path . $get_folder[$page-1]['name'] . "/");
////            $get_folder_first = false;
//            echo $get_folder_first;
    } else {
        for ($i = 0; $i < $get_folder_len; $i++) {
            if ($get_folder[$i]['is_dir']) {
                array_push($task_id, $path . $get_folder[$i]['name']);
//            $get_folder_first = true;
                get_folder_path($path . $get_folder[$i]['name'] . "/");
//            $get_folder_first = false;
            } else {
                break;
            }
        }
    }

    $task_id_len = count((array)$task_id);
}

$Task_head = '
{
	"ret": 200,
	"data": [{
		"id": "4434138",
		"taskmng_id": "107686",
		"task_id": "';

$Task_middle1 = '",
		"student_id": "1603007",
		"taskstate": "3",
		"sum_score": "0.0",
		"remark_sid": null,
		"s_remark_count": "0",
		"remark_tid": null,
		"t_remark_count": "0",
		"remark_repulse": null,
		"remind": null,
		"remind_time": null,
		"submit_time": null,
		"create_time": "2022-04-08 10:16:23",
		"create_userid": "1100101",
		"update_time": "2022-04-08 10:16:23",
		"update_userid": "1100101",
		"delete_flag": "1",
		"delay": "1",
		"consumingtime": "79",
		"remid": null,
		"remark_time": null,
		"remark_uni": "0",
		"oral_json": null,
		"game_answer": null,
		"s_task_tags": null,
		"recommend": "0",
		"delayed_time": 0,
		"limited_time": 0,
		"starttime": "114514",
		"state": 5,
		"endtime": "1919810",
		"markingtype": "1",
		"taskname": "';

$Task_middle2 = '",
		"tasktype": "1",
		"taskmodule": "1",
		"chaper_id": "33314",
		"taskdesc": "",
		"realname": "by:冰糖主人的电子宠物",
		"texttime": 0,
		"delayed_time2": 0,
		"studentclass_id": "213",
		"studentgroup_id": "0",
		"oral_id": null,
		"must_sub": "1",
		"is_cutting": "1",
		"exam_type": "0",
		"testfile": null,
		"game_type": null,
		"now": 1651636889,
		"start": 1649384040,
		"end": 1649470440,
		"isdelayed": "0",
		"q_revision": "",
		"chaptername": "冰糖主人的小脚软软的香香的",
		"oral_url": "https:\/\/kouyu.gankao.com\/work\/",
		"gkurl": null,
		"gameurl": ""
	},
	{
		"id": "4434138",
		"taskmng_id": "107686",
		"task_id": "';

$Task_bottom = '",
		"tasktype": "1",
		"taskmodule": "1",
		"chaper_id": "33314",
		"taskdesc": "",
		"realname": "by:冰糖主人的电子宠物",
		"texttime": 0,
		"delayed_time2": 0,
		"studentclass_id": "213",
		"studentgroup_id": "0",
		"oral_id": null,
		"must_sub": "1",
		"is_cutting": "1",
		"exam_type": "0",
		"testfile": null,
		"game_type": null,
		"now": 1651636889,
		"start": 1649384040,
		"end": 1649470440,
		"isdelayed": "0",
		"q_revision": "",
		"chaptername": "冰糖主人的小脚软软的香香的",
		"oral_url": "https:\/\/kouyu.gankao.com\/work\/",
		"gkurl": null,
		"gameurl": ""
	}],
	"msg": ""
}';

function make_task_head()
{
    global $task_id_len, $Task_head, $task_id, $Task_middle1, $Task_middle2, $Task_bottom;
    for ($i = 0; $i < $task_id_len; $i++) {
        if ($i != $task_id_len - 1) {
            $Task_head = $Task_head . $task_id[$i] . $Task_middle1 . $task_id[$i] . $Task_middle2;
        } else {
            $Task_head = $Task_head . $task_id[$i] . $Task_middle1 . $task_id[$i] . $Task_bottom;
        }
    }
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
    $page = $query_arr['page'];
    //遍历文件夹
    get_folder_path("/");
    make_task_head();
    exit($Task_head);
} elseif ($mode == "App.Knowledge.GetSubject") {
    exit($Subject);
} elseif ($mode == "App.Knowledge.GetSourseInfo") {
    $file_type = $query_arr['taskid'];
    get_file($file_type);
} elseif ($mode == "App.Report.GetZongheReport") {
    exit('{"ret":200,"data":"http://192.168.1.77/index.php","msg":""}');
}
