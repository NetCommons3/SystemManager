/**
 * @fileoverview SystemManager Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * SystemManager Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('SystemManager', function($scope) {

  /**
   * Radio click
   *
   * @return {void}
   */
  $scope.click = function($event, domId) {
    if (domId) {
      $('#' + domId).checked = true;
    }
    return Number($event.target.value);
  };

  /**
   * select click
   *
   * @return {void}
   */
  $scope.select = function(domId, $event) {
    $scope[domId] = $event.target.value;
  };

});
