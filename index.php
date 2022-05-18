<?php
//获取url中的参数
$query_str = $_SERVER['QUERY_STRING'];

// parse_str($query_str); /* 这种方式可以直接使用变量$id, $category, $title */

parse_str($query_str, $query_arr);
$mode = $query_arr['service'];
$lesson = '{"ret": 200,"data": {"list": [';
$name = array(
	"关注冰糖io，人生永远得优",
	"间谍过家家1",
	"间谍过家家2",
	"间谍过家家3",
	"间谍过家家4",
	"间谍过家家5",
	"间谍过家家6",
	"三体",
	"生物2022年5月9日" 
);
$res = array(
	"http://192.168.1.77:99/chfs/shared/%E5%85%B3%E6%B3%A8%E5%86%B0%E7%B3%96io%EF%BC%8C%E4%BA%BA%E7%94%9F%E6%B0%B8%E8%BF%9C%E5%BE%97%E4%BC%98.png",
	"http://192.168.1.77:99/chfs/shared/01.mp4",
	"http://192.168.1.77:99/chfs/shared/02.mp4",
	"http://192.168.1.77:99/chfs/shared/03.mp4",
	"http://192.168.1.77:99/chfs/shared/04.mp4",
	"http://192.168.1.77:99/chfs/shared/05.mp4",
	"http://192.168.1.77:99/chfs/shared/06.mp4",
	"http://192.168.1.77:99/chfs/shared/三体.pdf",
	"http://192.168.1.77:99/chfs/shared/生物2022年5月9日.zip"
);
for ($i = 0; $i < count($name); $i++) {
	if ($i != count($name) - 1) {
		$lesson = $lesson . '{"id": "关注冰糖io，人生永远得优","task_id": "关注冰糖io，人生永远得优","resource_id": "3240910","uri": "' . $res[$i] . '","title": "' . $name[$i] . '","type": "9","size": "2.27 MB","sources": 1,"delete_flag": "1","is_read": "1","course_id": "","section_id": "","vtype": 0,"isread": 1},';
	} else {
		$lesson = $lesson . '{"id": "关注冰糖io，人生永远得优","task_id": "关注冰糖io，人生永远得优","resource_id": "3240910","uri": "' . $res[$i] . '","title": "' . $name[$i] . '","type": "9","size": "2.27 MB","sources": 1,"delete_flag": "1","is_read": "1","course_id": "","section_id": "","vtype": 0,"isread": 1}';
	}
}
$Task = '
{
	"ret": 200,
	"data": [{
		"id": "4434138",
		"taskmng_id": "107686",
		"task_id": "50726",
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
		"taskname": "冰糖主人的电子宠物",
		"tasktype": "1",
		"taskmodule": "1",
		"chaper_id": "33314",
		"taskdesc": "",
		"realname": "冰糖主人",
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
}
';

$Subject = '
{
	"ret": 200,
	"data": [{
		"subjectcd": "410",
		"subjectname": "DD学",
		"stagecd": "4",
		"icon": "https://img.moegirl.org.cn/common/4/45/Overidea%E6%A0%87%E5%BF%97.png",
		"icon2": "https://img.moegirl.org.cn/common/4/45/Overidea%E6%A0%87%E5%BF%97.png",
		"count": "2"
	}],
	"msg": ""
}
';

if ($mode == "App.Task.GetAfterClass") {
	exit($Task);
} elseif ($mode == "App.Knowledge.GetSubject") {
	exit($Subject);
} elseif ($mode == "App.Knowledge.GetSourseInfo") {
	exit($lesson . '],"taskinfo": {"web_taskinfo": "资源：《2.2 二项分布及其应用 》","web_starttime": "2022-04-08 10:14:00","web_endtime": "2022-04-09 10:14:00","web_chaper": "2.2 二项分布及其应用 ","web_taskdesc": "","web_limited_time": "0"},"allread": 1,"costtime": "79"},"msg": ""}');
}
