define(['jquery'], function ($) {
    function currentFloor(id) {
        $('.button_elevator').removeClass('active_elevator_floor');

        $('#' + id).removeClass('press_button_elevator').addClass('active_elevator_floor');
    };

    function workElevator() {
        $.ajax({
                   type: "POST",
                   url: "/newmagento/elevator/baseelevator/movement",
                   success: function (data) {
                       if (data.arrived) {
                           currentFloor(data.currentFloor);
                           $.ajax({
                                      type: "POST",
                                      url: "/newmagento/elevator/baseelevator/free",
                                      success: function (myFreeData) {
                                          if (myFreeData.go === 0) {
                                          } else {
                                              callElevator(myFreeData);
                                          }
                                      }
                                  })
                       } else {
                           currentFloor(data.currentFloor);
                           setTimeout(function () {
                               workElevator()
                           }, 0);

                       }

                   }
               })
    };

    function callElevator(mydata) {
        $.ajax({
                   type: "POST",
                   url: "/newmagento/elevator/baseelevator/call",
                   data: mydata,
                   success: function (moveResponce) {
                       if (moveResponce.broken === 1) {// elevator is  broken
                           alert('ELEVATOR IS BROKEN');
                           return 0;
                       }
                       if (moveResponce.allow === 0) {     // floor isn't available
                           alert('Please choose another floor');
                           return 0;
                       }
                       if (moveResponce.busy === 1) {     // floor isn't available
                           return 0;
                       }
                       currentFloor(moveResponce.currentFloor);
                       workElevator();
                   }
               });
    }

    return function (config, node) {
        var mydata = {};
        mydata.elevatorId = config.elevator_id;

        var elements = $('.button_elevator');
        elements.on('click', function () {
            mydata.neededFloor = this.id;
            this.classList.add('press_button_elevator');
            callElevator(mydata);
        })
    }
});

