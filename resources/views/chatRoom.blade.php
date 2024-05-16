<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- component -->
    <div class="flex flex-col md:flex-row h-[85vh] antialiased text-gray-800">
        <div class="conversation-list flex flex-col overflow-y-scroll h-full w-full md:w-96 md:flex-shrink-0 bg-gray-100 p-4 md:block">
            <div class="flex flex-col w-full h-full pl-4 pr-4 py-4 -mr-4">
<!--
                <div class="flex items-center justify-center p-1">
                    <label for="toggleNotifications" class="flex items-center cursor-pointer">
                        &lt;!&ndash; toggle &ndash;&gt;
                        <div class="relative">
                            &lt;!&ndash; input &ndash;&gt;
                            <input id="toggleNotifications" type="checkbox" class="sr-only" />
                            &lt;!&ndash; line &ndash;&gt;
                            <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                            &lt;!&ndash; dot &ndash;&gt;
                            <div class="toggle-dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
                        </div>
                        &lt;!&ndash; label &ndash;&gt;
                        <div class="ml-3 text-gray-700 font-medium">
                            Activer les notifications
                        </div>
                    </label>
                </div>
-->

                <div class="flex flex-row items-center">
                    <div class="flex flex-row items-center">
                        <div class="text-xl font-semibold">Messages</div>
                    </div>
                    <div class="ml-auto">
                        <button class="flex items-center justify-center h-7 w-7 bg-gray-200 text-gray-500 rounded-full">
                            <svg class="w-4 h-4 stroke-current"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-5 flex flex-row justify-center">
                    <button id="groupTab" class="px-4 py-2 bg-blue-500 text-white rounded-l-lg focus:outline-none">Groupes</button>
                    <button id="privateTab" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-lg focus:outline-none">Conversations</button>
                </div>

                <div id="groupContainer" class="overflow-y-scroll overflow-x-hidden mt-5">
                    <div class="flex flex-col -mx-4">
                        <!-- Les groupes seront ajoutés ici par JavaScript -->
                    </div>
                </div>

                <div id="privateContainer" class="overflow-y-scroll overflow-x-hidden mt-5 hidden">
                    <div class="flex flex-col -mx-4">
                        <!-- Les conversations privées seront ajoutées ici par JavaScript -->
                    </div>
                </div>

                <!-- Bouton de création de groupe -->
                <div class="fixed bottom-20 left-60 m-4">
                    <button class="flex items-center justify-center shadow-sm h-10 w-10 bg-red-500 text-white rounded-full" id="btn_affiche_user">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="conversation flex flex-col overflow-y-auto h-full w-full md:flex-grow bg-white px-4 py-6">
            <div id="groupHeader" class="flex flex-row items-center py-4 px-6 rounded-2xl shadow">
                <button id="backButton" class="mr-2 md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div id="groupLogo" class="flex items-center justify-center h-10 w-10">
                    <div class="flex items-center justify-center h-10 w-10">Messagerie</div>
                </div>
                <div class="flex flex-col ml-3">
                    <div id="groupName" class="font-semibold text-sm"></div>
                </div>
                <div class="ml-auto">
                    <ul class="flex flex-row items-center space-x-2">
                        <li>
                            <a href="#" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-400 h-10 w-10 rounded-full">
                <span>
                  <svg class="w-5 h-5"
                       fill="none"
                       stroke="currentColor"
                       viewBox="0 0 24 24"
                       xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                  </svg>
                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="h-full overflow-hidden py-4">
                <div class="h-full overflow-y-auto">
                    <div class="grid grid-cols-12 gap-y-2">
                        <!-- Les messages seront ajoutés ici par JavaScript -->
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div id="previewContainer" class="flex justify-center space-x-2 p-2"></div>
                <div class="flex items-center w-full border rounded-3xl h-12 px-4">
                    <input type="text" id="messageInput" class="border-transparent w-full focus:outline-none text-sm h-10" placeholder="Type your message....">
                    <div class="flex items-center space-x-2">
                        <button id="btn_image" class="flex items-center justify-center h-10 w-8 text-gray-400 ml-1 mr-2">
                            <input type="file" id="fileInput" style="display: none;" accept="image/*,video/*" multiple>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="ml-6">
                    <button id="sendButton" class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 hover:bg-gray-300 text-indigo-800 text-white">
                        <svg class="w-5 h-5 transform rotate-90 -mr-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale -->
    <div id="userModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-100 p-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Utilisateurs</h3>
                </div>
                <div class="p-4">
                    <input type="text" placeholder="Rechercher..." class="mb-4 px-3 py-2 border border-gray-300 rounded-md w-full">
                    <button class="mb-4 px-4 py-2 bg-blue-500 text-white rounded-md" id="nouveau-groupe-btn">Nouveau Groupe</button>
                    <div id="groupNameContainer" class="hidden mb-4">
                        <input type="text" id="groupNameInput" placeholder="Nom du groupe" class="px-3 py-2 border border-gray-300 rounded-md w-full">
                    </div>
                    <div id="userList" class="max-h-60 overflow-auto">
                        <ul id="userListContainer" class="list-disc pl-5">
                            <!-- Les utilisateurs seront ajoutés ici par JavaScript -->
                        </ul>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" id="btn_fermer_modal_">
                        Fermer
                    </button>
                    <button id="nextButton" type="button" class="hidden w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-up container -->
    <div id="notificationPopup" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" onclick="closePopup()">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" onclick="event.stopPropagation()">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Gérer les notifications</h3>
                    <button onclick="closePopup()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="notificationPopup">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="mt-2 px-7 py-3">
                    <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="mt-3 mb-2 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Allow for Notification</button>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/chatRoom/notif.js'])
    @vite(['resources/js/chatRoom/affiche_user.js'])
    @vite(['resources/js/chatRoom/btn_image.js'])
    @vite(['resources/js/bootstrap.js'])

<!--
    <script defer>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(function(registration) {
                    console.log('Service Worker Registered', registration);
                })
                .catch(function(err) {
                    console.log('Service Worker Registration Failed', err);
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toggleNotifications = document.getElementById('toggleNotifications');
            const toggleDot = document.querySelector('.toggle-dot');

            // Appliquer les styles initiaux au dot toggle
            toggleDot.style.position = 'absolute';
            toggleDot.style.width = '24px'; // 6rem in Tailwind
            toggleDot.style.height = '24px'; // 6rem in Tailwind
            toggleDot.style.backgroundColor = 'white';
            toggleDot.style.borderRadius = '9999px'; // rounded-full in Tailwind
            toggleDot.style.boxShadow = '0 2px 4px 0 rgba(0,0,0,0.2)';
            toggleDot.style.transition = 'transform 0.3s ease-in-out';
            toggleDot.style.left = '-0.25rem'; // -1 in Tailwind
            toggleDot.style.top = '-0.25rem'; // -1 in Tailwind

            toggleNotifications.addEventListener('change', function () {
                if (this.checked) {
                    console.log("Notifications activées");
                    initFirebaseMessagingRegistration()

                    toggleDot.style.transform = 'translateX(100%)';
                    toggleDot.style.backgroundColor = '#48bb78'; // green-500 in Tailwind
                } else {
                    console.log("Notifications désactivées");
                    toggleDot.style.transform = 'translateX(0)';
                    toggleDot.style.backgroundColor = 'white';
                }
            });
        });

    </script>
-->

    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyCxxKnWhC3mcOalpB-FCWJoA9Kg9jSCnPs",
            authDomain: "push-notification-56ed1.firebaseapp.com",
            projectId: "push-notification-56ed1",
            storageBucket: "push-notification-56ed1.appspot.com",
            messagingSenderId: "693422657082",
            appId: "1:693422657082:web:9998341db608b8d576af03",
            measurementId: "G-FJVMG71W9Q"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            if (['Safari', 'iOS'].includes(navigator.vendor)) {
                document.getElementById('btn-nft-enable').addEventListener('click', function () {
                    requestPermissionForSafari();
                });
            } else {
                messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken()
                    })
                    .then(function (token) {
                        console.log(token);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route("save-token") }}',
                            type: 'POST',
                            data: {
                                token: token
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                alert('Token saved successfully.');
                            },
                            error: function (err) {
                                console.log('User Chat Token Error' + err);
                            },
                        });
                    }).catch(function (err) {
                    console.log('User Chat Token Error' + err);
                });
            }
        }

        function requestPermissionForSafari() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');

                    messaging.getToken().then(function(token) {
                        console.log(token);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route("save-token") }}',
                            type: 'POST',
                            data: {
                                token: token
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                alert('Token saved successfully.');
                            },
                            error: function (err) {
                                console.log('User Chat Token Error' + err);
                            },
                        });
                    }).catch(function(err) {
                        console.log('Error getting token for Safari: ' + err);
                    });
                } else {
                    console.log('Unable to get permission to notify.');
                }
            });
        }

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });


    </script>
</x-app-layout>
