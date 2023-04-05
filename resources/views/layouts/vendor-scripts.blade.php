<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js') }}"></script>
<script type='text/javascript' src='{{ URL::asset('assets/libs/toastify-js/toastify-js.min.js') }}'></script>
<script type='text/javascript' src='{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}'></script>
<script type='text/javascript' src='{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}'></script>
<script type='text/javascript' src='{{ URL::asset('assets/js/utils.js') }}'></script>
<script src="https://www.gstatic.com/firebasejs/8.6.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.0/firebase-messaging.js"></script>

<script>
    function notification(msg) {
        var element = document.getElementById("myToast");
        var myToast = new bootstrap.Toast(element);
        document.querySelector(".toast-body").innerHTML = msg;
        myToast.show();
    }

    function notification_success(msg) {
        var element = document.getElementById("toast_success");
        var myToast = new bootstrap.Toast(element);
        document.querySelector("#toast_success .toast-body").innerHTML = msg;
        myToast.show();
    }


    // Import the functions you need from the SDKs you need

    // TODO: Add SDKs for Firebase products that you want to use

    // https://firebase.google.com/docs/web/setup#available-libraries


    // Your web app's Firebase configuration

    // For Firebase JS SDK v7.20.0 and later, measurementId is optional

    const firebaseConfig = {

        apiKey: "AIzaSyBcffmPoCZJERSa2-RJaebPu9-K1G4IRGU",

        authDomain: "ahamd-hospital-fc738.firebaseapp.com",

        projectId: "ahamd-hospital-fc738",

        storageBucket: "ahamd-hospital-fc738.appspot.com",

        messagingSenderId: "144395845459",

        appId: "1:144395845459:web:f8b5f3f5fb6995afadaba6",

        measurementId: "G-TM9K4LY8JH"

    };


    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging.requestPermission().then(function() {
            return messaging.getToken()
        }).then(function(token) {

            $.ajax({
                url: "{{ route('fcmToken') }}",
                method: 'patch',
                data: {
                    token: token,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                },
                error: function(response) {

                }
            }).done(function() {
                setTimeout(function() {
                    $("#overlay").fadeOut(200);
                }, 500);
            });
        }).catch(function(err) {
            console.log(`Token Error :: ${err}`);
        });
    }

    initFirebaseMessagingRegistration();


    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        //const click_action = payload.notification.click_action;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });


    $('#form_comment').on('submit', function(e) {
        e.preventDefault();
        var _this = this;
        var comment = $('#comment').val();
        $.ajax({
            url: _this.action,
            data: {
                _token: '{{ csrf_token() }}',
                comment: comment
            },
            method: _this.method,
            success: function(response) {
                _this.reset();
                $('.comments').empty().html(response)
            }
        }).done(function() {
            setTimeout(function() {
                $("#overlay").fadeOut(200);
            }, 500);
        });
    })
</script>
@yield('script')
@yield('script-bottom')
