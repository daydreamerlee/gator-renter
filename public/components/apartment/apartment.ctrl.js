app.controller('apartmentController', ['$scope', '$routeParams', 'Apartment', 'NgMap', function($scope, $routeParams, Apartment, NgMap) {
	
	Apartment.get({ id: $routeParams['apartment_id'] }).$promise.then(function(data) {
		$scope.apartment = data;
		NgMap.getMap().then(function(map) {
			console.log(map.getCenter());
			console.log('markers', map.markers);
			console.log('shapes', map.shapes);
		});
	});
	
}]);