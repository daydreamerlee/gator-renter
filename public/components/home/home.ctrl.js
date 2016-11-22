app.controller('homeController', ['$location', '$scope', '$rootScope', 'Apartment', function($location, $scope, $rootScope, Apartment) {

    Apartment.query().$promise.then(function(data) {
    	$scope.originalApartments = data;
    	$scope.apartments = $scope.originalApartments;
    });

	$rootScope.showLogin = false;
	$rootScope.showSignup = false;

	$rootScope.showLoginLink = true;
	$rootScope.showSigninLink = true;
	$rootScope.showUserName = false;
	$rootScope.errorMessage = false;

	$scope.propertyName = 'title';
	$scope.reverse = true;

	$scope.view = 'list';

	$scope.privateRoom = false;
	$scope.privateBath = false;
	$scope.kitchenIn = false;
	$scope.noDeposit = false;
	$scope.noCredit = false;

	/* Methods */

	$rootScope.login = function() {
		// login the user with $rootScope.username and $rootScope.password
		$.ajax({
			method: "GET",
			dataType : "json",
			url: "api/login",
			data: {
				loginname : $rootScope.username,
				password: $rootScope.password
			}
		}).always(function (result) {
			if (result.first_name) {
				$("#showUserName").text(result.first_name + " " + result.last_name);
				$rootScope.showLoginLink = false;
				$rootScope.showSigninLink = false;
				$rootScope.showUserName = true;
				$rootScope.showLogin = false;
				$rootScope.errorMessage = false;
			}
			else {
				$rootScope.errorMessage = true;
			}
		});
	};

	$rootScope.logout = function() {
		if (confirm("Do you want to log out?")) {
			$rootScope.showLoginLink = true;
			$rootScope.showSigninLink = true;
			$rootScope.showUserName = false;
		}
	};

	$rootScope.signup = function() {
		$("#showUserName").text($rootScope.first_name + " " + $rootScope.last_name );
		$rootScope.showLoginLink = false;
		$rootScope.showSigninLink = false;
		$rootScope.showUserName = true;
		$rootScope.showSignup = false;

		$.ajax({
			method: "POST",
			dataType : "json",
			url: "api/Users",
			data: {
				first_name : $rootScope.first_name,
				last_name: $rootScope.last_name,
				email : $rootScope.username,
				password : $rootScope.password,
				address : $rootScope.address,
				city : "Fulda",
				role_type_id : "2"
			}
		}).always(function (result) {
			console.log(result);
		});
	};

	$scope.update = function() {
		if($scope.minPrice == '') $scope.minPrice = undefined;
		if($scope.maxPrice == '') $scope.maxPrice = undefined;
		if($scope.minPrice == undefined && $scope.maxPrice == undefined) {
			$scope.apartments = $scope.originalApartments;	
		} else {
			$scope.apartments = [];
			if($scope.minPrice == undefined && $scope.maxPrice != undefined) {
				var min = 0;
				var max = parseFloat($scope.maxPrice);
			} else if($scope.minPrice != undefined && $scope.maxPrice == undefined) {
				var min = parseFloat($scope.minPrice);
				var max = 100000;
			} else {
				var min = parseFloat($scope.minPrice);
				var max = parseFloat($scope.maxPrice);
			}
			angular.forEach($scope.originalApartments, function(apartment, key) {
				if(apartment.monthly_rent >= min && apartment.monthly_rent <= max) {
					$scope.apartments.push(apartment);
				}
			});
		}
	};

	$scope.sortBy = function(propertyName) {
		$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
		$scope.propertyName = propertyName;
	};

	$scope.go = function(path) {
		$location.path(path);
	};

}]);