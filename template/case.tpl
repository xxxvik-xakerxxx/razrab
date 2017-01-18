{include file="header2.tpl"}
<section>
	<script src="/template/js/notify.js" ></script>
		<script src="/template/js/sweetalert.min.js" ></script>
		<link rel="stylesheet" type="text/css" href="/template/css/sweetalert.css">
		<div class="opencase">
			<div class="opencase-title"><a href="/">Main-> </a> {case_title}</div>
			<div class="opencase-top widther">
				<div class="opencase-top-case {case_viz}" style="background-image:url(/template/img/{case_picture})"></div>


				<div class="opencase-top-carousel">
					<div class="opencase-top-carousel-line"></div>
					<div class="opencase-top-carousel-selector"></div>
				</div>
			</div>

			<div class="opencase-bottom widther">
		        <div style="margin-right: 30px;"><div class="opencase-bottom-open" data-id="{case_name}">открыть кейс за {case_price} Р.</div></div>
				<div class="opencase-bottom-auth"><a class="opencase-bottom-auth1" href="/steam?login">авторизуйтесь</a></div>
				<div class="opencase-bottom-items">К сожалению в данном кейсе нет вещей, попробуйте позже!</div>
				<div class="opencase-bottom-case">Вы слишком много раз открывали данный кейс.</div>
				<div class="opencase-bottom-case1">Кейс недоступен.</div>
				<div class="opencase-bottom-opening">открываем...</div>
				<div class="opencase-bottom-nofunds">
					<div class="opencase-bottom-nofunds-title">недостаточно средств</div>
					<div class="opencase-bottom-nofunds-subtitle">У вас недостаточно средств для открытия кейса!</div>
					<div class="opencase-bottom-nofunds-add">
					<span class="addmoneys1" style="display: inline-block;">
					<form action="/pay" method="POST">
						<input name="money" type="number" min="0" placeholder="Сумма" class="invoiceMoneys1">
						<button class="refills">Пополнить</button>
					</form>
					</span>
					</div>
				</div>
			</div>
			<div class="opencase-opened none widther">
				<div class="opencase-opened-title">Ваш выигрыш:</div>
				<div class="opencase-opened-image" style="background-image:url(//steamcommunity-a.akamaihd.net/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpopuP1FAR17OORIXBD_9W_mY-dqPrxN7LEm1Rd6dd2j6eV8Yijilfi-xJoMGv7LI7Hd1Q4Y1HV-VS8lOnmjJXvu87MzHsyv3Nw-z-DyMkIAv9h/360x360)"></div>
				<div class="opencase-opened-congrat">ПОЗДРАВЛЯЕМ!</div>
				<div class="opencase-opened-out">Предмет нужно вывести в профиле в течение часа.</div>
				<div class="opencase-opened-actions widther">
					<div class="opencase-opened-actions-one s__again">
						<div class="opencase-opened-actions-one-image"><i class="fa fa-repeat"></i></div>
						<div class="opencase-opened-actions-one-text">Ещё раз</div>
					</div>
					<a class="opencase-opened-actions-one s__sell">
						<div class="opencase-opened-actions-one-image"><i class="fa fa-shopping-bag"></i></div>
						<div class="opencase-opened-actions-one-text">Продать за ?Р</div>
					</a>

				</div>
			</div>
			<div class="opencase-dropstitle">Содержимое кейса:</div>
			<div class="items-incase widther">
				{case_in}
			</div>
		</div>
	</section>
{include file="footer.tpl"}
