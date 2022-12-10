<?php
/*
Name:卡密登录
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	if($app_res['logon_state']=='n')out(103,$app_res['logon_notice'],$app_res);//判断是否可登录
	if($app_res['logon_way'] != 1)out(163,$app_res);//不允许卡密登录
	
	
	$kami = isset($data_arr['kami']) && !empty($data_arr['kami']) ? purge($data_arr['kami']) : out(148,$app_res);//卡密为空
	$uuid = isset($_GET['uuid']) ? addslashes($_GET['uuid']) : '';
	if($app_res['kmlogon_check_in']=='y' && $uuid == '')out(112,$app_res);//判断是否验证机器码 112机器码为空

	$res_kami = Db::table('kami')->where('appid',$appid)->where('kami',$kami)->find();//false
    if($res_kami['uuid']=='') Db::table('kami')->where('id',$res_kami['id'])->update(['uuid'=>$uuid]);//写入机器码
    
	if(!$res_kami)out(149,$app_res);//卡密不存在
	$res_kami = Db::table('kami')->where('appid',$appid)->where('kami',$kami)->find();//false
	if($res_kami['uuid']!==$uuid && $app_res['kmlogon_check_in']=='y')out(402,$app_res);//机器码不匹配
	if(!empty($res_kami['user_time']))out(150,$app_res);//卡密已使用
	if($res_kami['state'] == 'n')out(151,$app_res);//卡密禁用


///原有登录


	if($res_kami['type'] == 'vip' && $app_res['kmlogon_check_in'] =='n'){
		if(empty($res_kami['use_time'])){//全新的卡密
			if($res_kami['amount'] == 999999999){
				$vip = $res_kami['amount'];
			}else{
				$vip = time() + 86400 * $res_kami['amount'];
			}
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}elseif($res_kami['end_time'] == '999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}else{
			out(201,'卡密已到期',$app_res);
		}
	}
	
	//积分卡
	if($res_kami['type'] == 'fen'){
	    out(167,$app_res);//不支持积分卡登录
	}
    //天卡
	if($res_kami['type'] == 'TK'){
		if(empty($res_kami['use_time'])){//全新的卡密
				$vip = time() + 86400 * $res_kami['amount'];
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}
		elseif($res_kami['end_time'] == '9999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}
		else{
			out(201,'卡密已到期',$app_res);
		}
		out(200,$kami_info,$app_res);
	}
	//周卡
	if($res_kami['type'] == 'ZK'){
		if(empty($res_kami['use_time'])){//全新的卡密
				$vip = time() + 86400 * $res_kami['amount'];
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}
		elseif($res_kami['end_time'] == '9999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}
		else{
			out(201,'卡密已到期',$app_res);
		}
		out(200,$kami_info,$app_res);
	}
	//月卡
	if($res_kami['type'] == 'YK'){
		if(empty($res_kami['use_time'])){//全新的卡密
				$vip = time() + 86400 * $res_kami['amount'];
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}
		elseif($res_kami['end_time'] == '9999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}
		else{
			out(201,'卡密已到期',$app_res);
		}
		out(200,$kami_info,$app_res);
	}
	
	//半年卡
	if($res_kami['type'] == 'BNK'){
		if(empty($res_kami['use_time'])){//全新的卡密
				$vip = time() + 86400 * $res_kami['amount'];
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}
		elseif($res_kami['end_time'] == '9999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}
		else{
			out(201,'卡密已到期',$app_res);
		}
		out(200,$kami_info,$app_res);
	}
	
	//年卡
	if($res_kami['type'] == 'NK'){
		if(empty($res_kami['use_time'])){//全新的卡密
				$vip = time() + 86400 * $res_kami['amount'];
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}
		elseif($res_kami['end_time'] == '9999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}
		else{
			out(201,'卡密已到期',$app_res);
		}
		out(200,$kami_info,$app_res);
	}
	//永久卡
	if($res_kami['type'] == 'YJK'){
		if(empty($res_kami['use_time'])){//全新的卡密
			if($res_kami['amount'] == 9999999999){
				$vip = $res_kami['amount'];
			}else{
				$vip = time() + 86400 * $res_kami['amount'];
			}	
			$res = Db::table('kami')->where('id',$res_kami['id'])->update(['use_time'=>time(),'end_time'=>$vip,'codestate'=>y]);//更新卡密信息
			if(!$res)out(201,'登录失败，请重试',$app_res);
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$vip
			];
		}
		elseif($res_kami['end_time'] == '999999999' or $res_kami['end_time'] > time()){
			$kami_info = [
				'kami'=>$kami,
				'vip'=>$res_kami['end_time']
			];
		}
		else{
			out(201,'卡密已到期',$app_res);
		}
		out(200,$kami_info,$app_res);
	}
	
	
?>