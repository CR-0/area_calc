<div ng-app="myApp" ng-controller="myCtrl as vm">
	<form>
	<table class="form-table-sample" border=1>
		<tr>
			<th></th>
			<th>Window Type(Colour)</th>
			<th>Price</th>
			<th></th>
		</tr>
		<tr ng-repeat="option in vm.settings">
			<th scope="row">
				<label for="area_calc-one">{{$index}}</label>
			</th>
			<td>
				<input type="text" ng-model="option.name">
			</td>
			<td>
				<input type="number" ng-model="option.price">
			</td>
			<td>
				<button ng-click="vm.del($index)">Delete</button>
			</td>
		</tr>
		<tr>
			<td colspan=4><button ng-click="vm.add()">Click me</button></td>
		</tr>
	</table>
	<table class="form-table-sample" border=1>
		<tr>
			<th>Minimum Width (cm)</th>
			<td><input type="number" ng-model="vm.minimum.width"></td>
		</tr>
		<tr>
			<th>Minimum Height (cm)</th>
			<td><input type="number" ng-model="vm.minimum.height"></td>
		</tr>
	</table>
	</form>	
	<form method="POST" action="options.php">
		<?php
			settings_fields('area_calc');
			do_settings_sections('area_calc');
		?>
		<input type="hidden" name="area_calc-one" value='{{vm.settings|json}}'>
		<input type="hidden" name="area_calc-two" value='{{vm.minimum|json}}'>
		<?php submit_button(); ?>
	</form>
	
	<pre>{{vm.settings|json}}</pre>
	<pre>{{vm.minimum|json}}</pre>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
<script>
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http)
{
	var vm = this;
	var check = function(minimum)
	{
		if(!(minimum !== null && typeof minimum === 'object'))
		{
			minimum = {"height":1,"width":1};
		}
		if(minimum.height == '' || minimum.height < 1 || typeof minimum.height != 'number')
		{
			minimum.height = 1; 
		}
		if(minimum.width == '' || minimum.width < 1 || typeof minimum.width != 'number')
		{
			minimum.width = 1; 
		}
		return minimum;
	}
	var revise = function(x)
	{
		if(!Array.isArray(x))
		{
			return [{"name":'Sample',"price":10}];
		}
		var i,l=x.length,a=[];
		for (i = 0; i < l; i++) {
			if (x[i]['name']!='' && x[i]['name']!=null && x[i]['price']!='' && x[i]['price']!=null && typeof x[i]['price'] == 'number' && parseInt(x[i]['price'])>0)
			{
				x[i]['price'] = parseInt(x[i]['price']);
				a.push(x[i]);
			}
		}
		return a;
	};
	vm.settings = revise(<?php echo get_option('area_calc-one');?>);
	vm.minimum = check(<?php echo get_option('area_calc-two');?>);
	
	vm.add = function()
	{
		vm.settings.push({"name":null,"price":null});
	}
	vm.del = function(item)
	{
		vm.settings.splice(item, 1);
	}
});



</script>



















