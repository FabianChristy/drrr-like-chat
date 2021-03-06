<div class="message_box">
<div class="message_box_inner">

<h2>
	<span id="room_name"><?php e($dura['room']['name']) ?></span>
	(<span id="room_total">?</span>/<span id="room_limit"><?php e($dura['room']['limit']) ?></span>)
</h2>
<div id="socialButton">
	<!-- 將此標�??�在?�想要顯�?+1 ?��??��?�?-->
	<div class="g-plusone" data-size="small" data-href="<?php echo DURA_URL ?>"></div>

	<!-- 將此顯示?�叫 (render call) ?�在?�當位置 -->
	<script type="text/javascript">
		window.___gcfg = {lang: '<?php echo Dura::user()->getLanguage(); ?>'};

		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
	</script>
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo DURA_URL ?>" data-text="<?php e(htmlspecialchars(t("I'm now chatting at room '{1}'!", $dura['room']['name']))) ?>" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<iframe src="http://www.facebook.com/plugins/like.php?app_id=154452591321345&amp;href=<?php echo rawurlencode(DURA_URL); ?>&amp;send=false&amp;layout=button_count&amp;width=120&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=trebuchet+ms&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;" allowTransparency="true"></iframe>
</div>

<form action="#" method="post" id="message">
<!--
<div class="right"><input type="submit" name="logout" value="LOGOUT" /></div>
-->
<ul class="menu">
<li class="setting">&nbsp;</li>
<li class="sound">&nbsp;</li>
<li class="member">&nbsp;</li>
<li class="animation">&nbsp;</li>
<li class="logout"><input type="submit" name="logout" value="<?php e(t("EXIT")) ?>" /></li>
<li></li>
</ul>
<div class="messageInput">

	<div class="user">
		<img src="<?php e(Dura_Class_Icon::getIconUrl($dura['user']['icon'])) ?>"/>
		<div title="<?php e($dura['user']['name']) ?>" class="userName"><?php e($dura['user']['name']) ?></div>
	</div>

<textarea name="message"></textarea>
</div>
<?php if ( $ret = file_exists(DURA_PATH.'/js/sound.mp3') ) : ?>
<a href="<?php echo DURA_URL ?>/static/js/sound.mp3" id="sound" class="hide">sound</a>
<?php endif ?>
<div class="submit">
<input type="submit" name="post" value="POST!" />
</div>
<ul id="members" class="hide">
<?php foreach ( $dura['room']['users'] as $user  ) : ?>
<li><?php e($user['name']) ?> <?php if ( $user['id'] == $dura['room']['host'] ) :?><?php e(t("(host)")) ?><?php endif ?></li>
<?php endforeach ?>
</ul>
<ul class="hide">
<li id="user_id"><?php e($dura['user']['id']) ?></li>
<li id="user_name"><?php e($dura['user']['name']) ?></li>
<li id="user_icon"><?php e($dura['user']['icon']) ?></li>
<li id="user_color"><?php e($dura['user']['color']) ?></li>
</ul>
</form>

<div id="setting_pannel" class="hide">
<?php e(t("Room Name")) ?> <input type="textbox" name="room_name" value="<?php e($dura['room']['name']) ?>" size="20" maxlength="10" /> <input type="button" name="save" value="<?php e(t("Change")) ?>" /><br />
<hr />
<input type="button" name="handover" value="<?php e(t("Handover host")) ?>" disabled="disabled" />
<input type="button" name="ban" value="<?php e(t("Ban user")) ?>" disabled="disabled" />

<ul id="user_list"></ul>

</div>

</div>
</div><!-- end #header -->

<div id="talks_box">
<div id="talks">
<?php foreach ( $dura['room']['talks'] as $talk ) : ?>
<?php if ( !$talk['uid'] ) : ?>
<div class="talk system" id="<?php e($talk['id']) ?>"><?php e($talk['message']) ?></div>
<?php else: ?>
<dl class="talk icon_<?php e($talk['icon']) ?>" id="<?php e($talk['id']) ?>">
<dt class="avatar <?php e($talk['icon']) ?>"><?php e($talk['name']) ?></dt>
<dd>
	<div class="bubble">
		<p class="body <?php e($talk['color']) ?>"><?php e($talk['message']) ?></p>
	</div>
</dd>
</dl>
<?php endif ?>
<?php endforeach ?>
</div><!-- /#talks -->
</div><!-- /#talks_box -->
