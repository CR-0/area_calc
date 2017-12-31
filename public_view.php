<style>
.area-calc-main-div
	{
		width:100%;
		position:relative;
		display:inline-block;
	}
.area-calc-table,th,td,tr
	{
		text-align:center!important;
	}
.centerPlease
	{
		display: table-cell;
		vertical-align: middle;
		text-align: center;
	}
.style-1
	{
		/*text-decoration:underline;*/
		font-style:italic;
	}
</style>
<div ng-app="myApp" ng-controller="myCtrl as vm" class="area-calc-main-div">
	<table class="area-calc-table">
		<tr>
			<th>Yükseklik</th>
			<th></th>
			<th>Genişlik</th>
			<th></th>
			<th>Alan</th>
		</tr>
		<tr>
			<td>
				<input type="number" ng-model="vm.area.height" ng-change="vm.calc()">
				<span class="style-1">cm</span>
			</td>
			<td class="centerPlease">x</td>
			<td>
				<input type="number" ng-model="vm.area.width" ng-change="vm.calc()">
				<span class="style-1">cm</span>
			</td>
			<td class="centerPlease">=</td>
			<td class="centerPlease">
				<span ng-bind="vm.area.total"></span>
				<span class="style-1">m&sup2;</span>
			</td>
		</tr>
		<tr ng-show="vm.minimum.height>vm.area.height || vm.minimum.width>vm.area.width">
			<td colspan=5>
				<div ng-show="vm.minimum.height>vm.area.height">Yükseklik <b>{{vm.minimum.height}} <i>cm</i></b> olarak hesaplanmıştır.</div>
				<div ng-show="vm.minimum.width>vm.area.width">Genişlik <b>{{vm.minimum.width}} <i>cm</i></b> olarak hesaplanmıştır.</div>
			</td>
		</tr>
		<tr ng-repeat="option in vm.settings">
			<th colspan=3 ng-bind="option.name"></th>
			<td colspan=2>
				<span ng-bind="vm.calcPrice(vm.area.total * option.price)"></span>&nbsp;&#x20BA;
			</td>
		</tr>
	</table>
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
			minimum = {"height":10,"width":10};
		}
		if(minimum.height == '' || typeof minimum.height != 'number')
		{
			minimum.height = 10; 
		}
		if(minimum.width == '' || typeof minimum.width != 'number')
		{
			minimum.width = 10; 
		}
		return minimum;
	}
	var revise = function(x)
	{
		if(!Array.isArray(x))
		{
			return [{"name":'isim',"price":0}];
		}
		var i,l=x.length,a=[];
		for (i = 0; i < l; i++) {
			if (x[i]['name']!='' && x[i]['name']!=null && x[i]['price']!='' && x[i]['price']!=null)
			{
				x[i]['price'] = parseInt(x[i]['price']);
				a.push(x[i]);
			}
		}
		return a;
	};
	vm.area = {"width":100,"height":200,"total":0,"price":0}
	vm.calcPrice = function(x)
	{
		x = parseFloat(x);
		return x.toFixed(2);
	}
	vm.calc = function()
	{
		if(typeof vm.area.height == 'number' && typeof vm.area.width == 'number' && vm.area.height > 0 && vm.area.width > 0)
			{
				vm.area.height = parseInt(vm.area.height);
				var height = vm.area.height < vm.minimum.height ? vm.minimum.height : vm.area.height; // min height 180 !!!
				
				vm.area.width = parseInt(vm.area.width);
				var width = vm.area.width < vm.minimum.width ? vm.minimum.width : vm.area.width; // min width 180 !!!
				
				vm.area.total = new Number(width * height / 10000).toFixed(2) ; 
			}
	}
	
	vm.settings = revise(<?php echo get_option('area_calc-one');?>);	
	vm.minimum = check(<?php echo get_option('area_calc-two');?>);

	vm.calc();
});



</script>



















