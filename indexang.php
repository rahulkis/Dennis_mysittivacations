<!doctype html>
<html ng-app="myApp" ng-cloak>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.angularjs.org/1.6.4/angular.min.js"></script>
		<script src="pret.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="https://mysittidev.com/images/v2_logo_round.png">
	</head>

	<body>

		<div ng-controller="thecontroller">
			Total = {{quantity / price}}
			<li ng-repeat="x in list">{{x}}</li>
			<hr />
			<button ng-mouseenter="count = count + 1" ng-init="count=0">
			  Increment (when mouse enters)
			</button>
			count: {{count}}	
		</div>
		<div ng-controller="ParentController">  
	        <form name="personForm" novalidate ng-submit="personForm.$valid &&sendForm()">

				Email:<input type="text" name="email" ng-model="txtmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required />

				<span style="color:Red" ng-show="personForm.email.$error.required"> Required! </span>
				<span style="color:Red" ng-show="personForm.email.$dirty&&personForm.email.$error.pattern">Please Enter Valid Email</span>
				<br /><br />
				<button type="submit">Submit Form</button><br /><br />
				<span>{{msg}}</span>

			</form> 
    	</div>
    	<hr />
    	<div class="container">
			<!-- <h1 align="center">Insert Data Into Database using Angular JS with PHP Mysql</h1> -->
			<div ng-controller="userController">
				<label>Name</label><input type="text" name="name" ng-model="name" class="form-control"><br/>
				<label>Email</label><input type="text" name="email" ng-model="email" class="form-control"><br/>
				<label>Age</label><input type="text" name="age" ng-model="age" class="form-control"><br/>
				<input type="submit" name="insert" class="btn btn-success" ng-click="insert()" value="Insert">
			</div>
			<div class="col-lg-12 col-sm-12 col-xs-12 alert alert-success" ng-show="successMessage">
			        <strong>{{successMessage }}</strong>
			</div>
		</div>
	</body>
</html>