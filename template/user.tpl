{include file="header.tpl"}
<script src="/template/js/sweetalert.min.js" ></script>
<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/template/css/sweetalert.css">
<div class="items-index">
		<div class="profil widther">
	<div class="userprofil">
					<div class="lcol">
						<img src="{user_avatar}" alt="{user_name}" width="186">
						<div class="otstup"></div>
<span class="addmoneys" style="display: inline-block;">

					<form action="/pay" method="POST">
						<input name="money" classs="moneys" type="number" min="0" placeholder="Сумма" class="invoiceMoneys" value="100">
						<button class="buttons refill" type="submit">+</button>
					</form>
					</span><div class="otstup"></div>
						<a href="https://steamcommunity.com/profiles/{user_steam}" target="_blank"  class="profsteam">Профиль STEAM</a>
					</div>
					<div class="container3">
						<div class="garant_boxes2">
							<div class="b33 block">
								<div class="head">
									<div class="top_s">
									1	<i class="fa fa-steam-square" aria-hidden="true"></i>
									</div>
								</div>
									<div class="body">

										Введите трейд-ссылку
									</div>
							</div>

							<div class="b33 block">
								<div class="head">
									<div class="top_s">
										2 <i class="fa fa-steam" aria-hidden="true"></i>
									</div>
								</div>
									<div class="body">

															Пополните баланс
									</div>
							</div>

							<div class="b33 block">
								<div class="head">
									<div class="top_s">
							3	<i class="fa fa-rub" aria-hidden="true"></i>
									</div>
								</div>
										<div class="body">
													Выигрывайте!
										</div>
							</div>
						</div>

					</div>
					<div class="rcol trade">
						<div class="tx">
								Вы можете поменять свою трейд ссылку в любое время. Узнать ее можно <a href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">здесь</a>
						</div>

								<input type="hidden" name="action" value="updateLink">
								<input type="url" id="tradelink" name="tradelink" class="tradelink" data-tradeurl="" value="{trade_link}" placeholder="https://steamcommunity.com/tradeoffer/new/?partner=YYYYYYYYY&amp;token=XXXXXXXX">
								<input type="submit" class="buttonz"  value="Сохранить">

					</div>
					<div class="rcol">

							<div>
							<div class="title23"><h2>Ваш инвентарь</h2></div>


						<div class="p-items">	{inventory} </div>
							<div class="opencase-drops nmg"></div>
						</div>
					</div>

				</div>
			</div>
		</div></div></div>
{include file="footer.tpl"}
