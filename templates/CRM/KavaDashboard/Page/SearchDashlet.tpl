<h3 class="kavadashboard-header">Zoek op naam, email of APB-nummer</h3>

<form action="" name="kavadashboard-search-form" id="kavadashboard-search-form" method="post" data-apb-field-name="{$apbFieldName}" data-overname-field-name="{$overnameFieldName}">
  <input type="text" class="form-text" id="kavadashboard-search-name" placeholder="{ts}Name/Email{/ts}" data-group="1">
  <input type="text" class="form-text" id="kavadashboard-search-apb" placeholder="{ts}APB-nummer{/ts}" data-group="2">
  <div class="clear"></div>
</form>

<div id="kavadashboard-search-spinner"></div>
<div id="kavadashboard-search-results"></div>
