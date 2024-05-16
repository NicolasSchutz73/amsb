import axios from "axios";
import Echo from 'laravel-echo';

let currentGroupId = null;
let groupChannels = {};
let globalFirstname = '';
let globalLastname = '';
let globalUserId = '';
let globalTeam = '';
let globalRole = '';
document.addEventListener('DOMContentLoaded', function() {
    const btnAfficheUser = document.getElementById('btn_affiche_user');
    const btnFermerModal = document.getElementById('btn_fermer_modal_');
    const nouveauGroupeBtn = document.getElementById('nouveau-groupe-btn');
    const nextButton = document.getElementById('nextButton');
    const selectAllUsers = document.getElementById('selectAllUsers');
    const searchUser = document.getElementById('searchUser');
    const filterTeam = document.getElementById('filterTeam');
    const filterRole = document.getElementById('filterRole');
    const backButton = document.getElementById('backButton');
    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');

    if (btnAfficheUser) btnAfficheUser.addEventListener('click', openModal);
    if (btnFermerModal) btnFermerModal.addEventListener('click', closeModal);
    if (nouveauGroupeBtn) nouveauGroupeBtn.addEventListener('click', toggleGroupCreationMode);
    if (nextButton) nextButton.addEventListener('click', createGroup);
    if (selectAllUsers) selectAllUsers.addEventListener('click', selectAllUsers);
    if (searchUser) searchUser.addEventListener('input', filterUsers);
    if (filterTeam) filterTeam.addEventListener('change', filterUsers);
    if (filterRole) filterRole.addEventListener('change', filterUsers);
    if (backButton) backButton.addEventListener('click', showConversationList);
    if (sendButton) sendButton.addEventListener('click', function() {
        sendMessage(messageInput.value);
        messageInput.value = '';
    });
    if (messageInput) messageInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            sendMessage(messageInput.value);
            messageInput.value = '';
        }
    });


    getUserInfoAsync().then(() => {
        loadUserGroups();
        loadUserConversation();
        startRefreshingConversations();
        loadUnreadMessagesCount();

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            console.log("new message");
            loadUserGroups();
            loadUserConversation();
        });

    }).catch(error => {
        console.error('Erreur lors de la récupération des informations utilisateur', error);
    });
});

let isGroupCreationActive = false;

function getUserInfoAsync() {
    return new Promise((resolve, reject) => {
        try {
            getUserInfo(); // votre fonction actuelle qui ne retourne pas de promesse
            resolve(); // Si tout va bien, résolvez la promesse
        } catch (error) {
            reject(error); // Si une erreur se produit, rejetez la promesse
        }
    });
}

function showConversationList() {
    const conversationList = document.querySelector('.conversation-list');
    const conversation = document.querySelector('.conversation');
    conversationList.classList.remove('hidden');
    conversation.classList.add('hidden');
}

function showConversation() {
    console.log("show");
    const conversationList = document.querySelector('.conversation-list');
    const conversation = document.querySelector('.conversation');
    conversationList.classList.add('hidden');
    conversation.classList.remove('hidden');
}
function toggleGroupCreationMode() {
    isGroupCreationActive = !isGroupCreationActive;
    const checkboxes = document.querySelectorAll('#userListContainer input[type="checkbox"]');
    const nextButton = document.getElementById('nextButton');
    const groupNameContainer = document.getElementById('groupNameContainer');

    if (isGroupCreationActive) {
        document.getElementById('groupNameInput').value = '';
        checkboxes.forEach(checkbox => checkbox.classList.remove('hidden'));
        nextButton.classList.remove('hidden');
        groupNameContainer.classList.remove('hidden');
    } else {
        checkboxes.forEach(checkbox => {
            checkbox.classList.add('hidden');
            checkbox.checked = false;
        });
        nextButton.classList.add('hidden');
        groupNameContainer.classList.add('hidden');
    }
}

function loadUsers() {
    axios.get('/api/users')
        .then(response => {
            const users = response.data;
            const userListContainer = document.getElementById('userListContainer');
            userListContainer.innerHTML = '';

            users.forEach(user => {
                const userItem = document.createElement('li');
                userItem.classList.add("flex", "items-center", "justify-between", "mb-2");
                userItem.setAttribute('data-user-id', user.id);
                userItem.setAttribute('data-team', user.teams);
                userItem.setAttribute('data-role', user.role);

                const userInfo = document.createElement('span');
                userInfo.textContent = `${user.firstname} ${user.lastname}`;
                userInfo.classList.add("text-gray-800", "flex-grow");

                const userCheckbox = document.createElement('input');
                userCheckbox.type = 'checkbox';
                userCheckbox.classList.add("form-checkbox", "h-5", "w-5", "text-blue-600", "hidden");
                userCheckbox.setAttribute('data-user-id', user.id);

                userItem.appendChild(userInfo);
                userItem.appendChild(userCheckbox);

                userItem.addEventListener('click', function(event) {
                    if (!isGroupCreationActive) {
                        startConversation(user.id);
                    } else if (event.target.type !== 'checkbox') {
                        userCheckbox.checked = !userCheckbox.checked;
                    }
                });

                userListContainer.appendChild(userItem);
            });

            populateFilterOptions(users);
        })
        .catch(error => console.error('Erreur lors du chargement des utilisateurs', error));
}

function populateFilterOptions(users) {
    axios.get('/api/teams').then(response => {
        const teams = response.data;
        const teamFilter = document.getElementById('filterTeam');
        teams.forEach(team => {
            const option = document.createElement('option');
            option.value = team.name;
            option.textContent = team.name;
            teamFilter.appendChild(option);
        });
    }).catch(error => console.error('Erreur lors du chargement des équipes', error));

    axios.get('/api/roles').then(response => {
        const roles = response.data;
        const roleFilter = document.getElementById('filterRole');
        roles.forEach(role => {
            const option = document.createElement('option');
            option.value = role.name;
            option.textContent = role.name;
            roleFilter.appendChild(option);
        });
    }).catch(error => console.error('Erreur lors du chargement des rôles', error));
}

function filterUsers() {
    const searchQuery = document.getElementById('searchUser').value.toLowerCase();
    const selectedTeam = document.getElementById('filterTeam').value;
    const selectedRole = document.getElementById('filterRole').value;
    const users = document.querySelectorAll('#userListContainer li');

    users.forEach(user => {
        const userName = user.querySelector('span').textContent.toLowerCase();
        const userTeam = user.getAttribute('data-team');
        const userRole = user.getAttribute('data-role');

        const matchesSearch = userName.includes(searchQuery);
        const matchesTeam = selectedTeam === '' || userTeam === selectedTeam;
        const matchesRole = selectedRole === '' || userRole === selectedRole;

        if (matchesSearch && matchesTeam && matchesRole) {
            user.classList.remove('hidden');
        } else {
            user.classList.add('hidden');
        }
    });
}



function createGroup() {
    const selectedUserIds = Array.from(document.querySelectorAll('#userListContainer input[type="checkbox"]:checked'))
        .map(checkbox => checkbox.getAttribute('data-user-id'));
    const groupName = document.getElementById('groupNameInput').value;

    axios.post('/create-group', {
        groupName: groupName,
        userIds: selectedUserIds
    })
        .then(() => {
            loadUserGroups();
        })
        .catch(error => {
            console.error('Erreur lors de la création du groupe', error);
        });

    closeModal();
    toggleGroupCreationMode();
}


function selectAllUsers() {
    const checkboxes = document.querySelectorAll('#userListContainer input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}



function openModal() {
    document.getElementById('userModal').classList.remove('hidden');
    loadUsers();
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
}

function getUserInfo() {
    const userId = globalUserId; // Assurez-vous que globalUserId est défini avant d'appeler cette fonction
    axios.get(`/user-details/${userId}`)
        .then(response => {
            const user = response.data;
            globalFirstname = user.firstname;
            globalLastname = user.lastname;
            globalUserId = user.id;
            globalTeam = user.team;
            globalRole = user.role;
            console.log('User info loaded:', globalFirstname, globalLastname, globalTeam, globalRole);
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des informations de l\'utilisateur', error);
        });
}

function loadUserGroups() {
    axios.get('/api/user-groups?type=group')
        .then(response => {
            const groups = response.data.groups;
            const groupsContainer = document.querySelector('.flex.flex-col.-mx-4');
            groupsContainer.innerHTML = '';

            groups.forEach(group => {
                const groupElement = document.createElement('div');
                groupElement.classList.add('flex', 'flex-row', 'items-center', 'p-4', 'relative');
                groupElement.setAttribute('data-group-id', group.id);

                const timeElement = document.createElement('div');
                timeElement.classList.add('absolute', 'text-xs', 'text-gray-500', 'right-0', 'top-0', 'mr-4', 'mt-3');
                timeElement.textContent = group.lastMessageTime || 'Un moment';
                timeElement.setAttribute('data-last-message-time', group.id);

                const iconElement = document.createElement('div');
                iconElement.classList.add('flex', 'items-center', 'justify-center', 'h-10', 'w-10', 'rounded-full', 'bg-blue-500', 'text-blue-300', 'font-bold', 'flex-shrink-0');
                iconElement.textContent = group.name.charAt(0);

                const groupInfoElement = document.createElement('div');
                groupInfoElement.classList.add('flex', 'flex-col', 'flex-grow', 'ml-3');
                const groupNameElement = document.createElement('div');
                groupNameElement.classList.add('text-sm', 'font-medium');
                groupNameElement.textContent = group.name;
                const lastMessageElement = document.createElement('div');
                lastMessageElement.classList.add('text-xs', 'truncate', 'w-40');
                lastMessageElement.textContent = group.lastMessageContent || 'Pas de messages';
                lastMessageElement.setAttribute('data-last-message', group.id);

                const newMessagesElement = document.createElement('div');
                newMessagesElement.classList.add('flex-shrink-0', 'ml-2', 'self-end', 'mb-1');
                const messagesCountElement = document.createElement('span');
                messagesCountElement.classList.add('flex', 'items-center', 'justify-center', 'h-5', 'w-5', 'bg-red-500', 'text-white', 'text-xs', 'rounded-full');
                messagesCountElement.textContent = group.newMessagesCount || '';

                groupInfoElement.appendChild(groupNameElement);
                groupInfoElement.appendChild(lastMessageElement);
                if (group.newMessagesCount > 0) {
                    newMessagesElement.appendChild(messagesCountElement);
                }
                groupElement.appendChild(timeElement);
                groupElement.appendChild(iconElement);
                groupElement.appendChild(groupInfoElement);
                groupElement.appendChild(newMessagesElement);

                groupElement.addEventListener('click', () => joinGroupChat(group.id, groupNameElement.textContent));

                subscribeToAllGroupChannels(groups);

                groupsContainer.appendChild(groupElement);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des groupes', error));
}

function joinGroupChat(groupId, groupName) {
    if (currentGroupId && groupChannels[currentGroupId]) {
        window.Echo.leave(`group.${currentGroupId}`);
        delete groupChannels[currentGroupId];
    }

    currentGroupId = groupId;

    const groupNameElement = document.getElementById('groupName');
    const groupLogoElement = document.getElementById('groupLogo');

    groupNameElement.textContent = groupName;
    groupLogoElement.textContent = groupName.charAt(0);
    groupLogoElement.classList.add('flex', 'items-center', 'justify-center', 'h-10', 'w-10', 'bg-blue-500', 'text-blue-300', 'text-m', 'rounded-full');

    document.querySelector('.grid.grid-cols-12.gap-y-2').innerHTML = '';

    updateLastVisitedAt(groupId);

    loadPreviousMessages(groupId);

    subscribeToGroupChannel(groupId);

    showConversation();
}

function subscribeToGroupChannel(groupId) {
    if (!groupChannels[groupId]) {
        groupChannels[groupId] = window.Echo.private(`group.${groupId}`)
            .listen('GroupChatMessageEvent', (e) => {
                appendMessageToChat(e.message.content, e.message.id, e.message.firstname, e.message.lastname, e.message.files);
                loadPreviousMessages(groupId);
            });
    }
}

function loadPreviousMessages(groupId) {
    axios.get(`/group-chat/${groupId}/messages`)
        .then(response => {
            const messages = response.data.messages;
            const chatDiv = document.querySelector('.grid.grid-cols-12.gap-y-2');
            chatDiv.innerHTML = '';

            messages.forEach(message => {
                appendMessageToChat(message.content, message.user_id, message.user_firstname, message.user_lastname, message.files);
            });
            const lastMessageElement = chatDiv.lastElementChild;
            if (lastMessageElement) {
                lastMessageElement.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }
        })
        .catch(error => console.error('Erreur lors du chargement des messages', error));
}

function sendMessage(messageContent) {
    const messageInput = document.querySelector('input[type="text"]');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');

    if (!currentGroupId) {
        console.error('No group selected');
        return;
    }

    const formData = new FormData();
    formData.append('groupId', currentGroupId);
    if (messageContent.trim()) {
        formData.append('message', messageContent);
    }

    Array.from(fileInput.files).forEach((file, index) => {
        formData.append(`files[${index}]`, file);
        console.log(file);
    });

    axios.post(`/group-chat/${currentGroupId}/send`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(() => {
            messageInput.value = '';
            previewContainer.innerHTML = '';
            fileInput.value = '';

            loadPreviousMessages(currentGroupId);
            triggerPushNotification(currentGroupId, messageContent, globalUserId);
            loadUserConversation();
            updateConversationPreview(currentGroupId);
        })
        .catch(error => {
            console.error('Erreur d\'envoi', error);
        });
}

function appendMessageToChat(messageContent, authorID, authorFirstname, authorLastname, fileData) {
    const chatDiv = document.querySelector('.grid.grid-cols-12.gap-y-2');
    const messageElement = document.createElement('div');

    const isCurrentUserMessage = authorID === globalUserId;

    if (isCurrentUserMessage) {
        messageElement.classList.add('col-start-6', 'col-end-13', 'p-3', 'rounded-lg', 'self-end', 'text-right');
    } else {
        messageElement.classList.add('col-start-1', 'col-end-8', 'p-3', 'rounded-lg', 'self-start', 'text-left');
    }

    const authorInfoDiv = document.createElement('div');
    authorInfoDiv.classList.add('mb-2', 'text', 'italic', 'text-gray-600', 'text-xs');
    authorInfoDiv.textContent = isCurrentUserMessage ? 'Vous' : `${authorFirstname} ${authorLastname}`;

    const flexDiv = document.createElement('div');
    flexDiv.classList.add('flex', 'items-center', isCurrentUserMessage ? 'justify-end' : 'justify-start');

    const initials = `${authorFirstname ? authorFirstname.charAt(0) : ''}${authorLastname ? authorLastname.charAt(0) : ''}`;
    const authorDiv = document.createElement('div');
    const authorLink = document.createElement('a');
    authorLink.href = '/usershow/' + String(authorID);
    authorDiv.appendChild(authorLink);
    authorDiv.classList.add('flex', 'items-center', 'justify-center', 'h-10', 'w-10', 'rounded-full', 'text-white', 'font-bold');
    authorDiv.style.backgroundColor = isCurrentUserMessage ? '#4F46E5' : '#CBD5E1';

    authorLink.textContent = initials.toUpperCase() || 'U';

    const messageContentDiv = document.createElement('div');
    messageContentDiv.classList.add('relative', 'text-sm', 'bg-white', 'py-2', 'px-4', 'shadow', 'rounded-xl');
    messageContentDiv.textContent = messageContent;

    if (isCurrentUserMessage) {
        flexDiv.appendChild(authorDiv);
        flexDiv.appendChild(messageContentDiv);
    } else {
        flexDiv.appendChild(messageContentDiv);
        flexDiv.appendChild(authorDiv);
    }

    if (fileData && fileData.length > 0) {
        fileData.forEach(file => {
            const { file_path, file_type } = file;
            const fileElement = document.createElement('div');
            fileElement.className = 'mt-2';

            if (file_type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = file_path;
                img.className = 'max-w-full h-auto rounded-lg';
                fileElement.appendChild(img);
            } else if (file_type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = file_path;
                video.controls = true;
                video.className = 'max-w-full h-auto rounded-lg';
                fileElement.appendChild(video);
            } else if (file_type.startsWith('audio/')) {
                const audio = document.createElement('audio');
                audio.src = file_path;
                audio.controls = true;
                fileElement.appendChild(audio);
            } else {
                const text = document.createElement('p');
                text.textContent = 'Type de fichier non pris en charge';
                fileElement.appendChild(text);
            }

            messageContentDiv.appendChild(fileElement);
        });

        const downloadAllBtn = document.createElement('button');
        downloadAllBtn.textContent = 'Enregistrer ⬇️';
        downloadAllBtn.classList.add('mt-2', 'text-sm', 'text-black', 'p-1', 'rounded');
        downloadAllBtn.onclick = () => {
            fileData.forEach((file) => {
                if (file.file_type.startsWith('image/') || file.file_type.startsWith('video/')) {
                    const link = document.createElement('a');
                    link.href = file.file_path;
                    link.download = '';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });
        };

        messageContentDiv.appendChild(downloadAllBtn);
    }

    messageElement.appendChild(authorInfoDiv);
    messageElement.appendChild(flexDiv);

    chatDiv.appendChild(messageElement);

    const lastMessageElement = chatDiv.lastElementChild;
    if (lastMessageElement) {
        lastMessageElement.scrollIntoView({ block: 'end' });
    }
}

function startConversation(userId) {
    axios.get(`/check-group/${globalUserId}/${userId}`)
        .then(response => {
            if (response.data.groupId) {
                joinGroupChat(response.data.groupId, response.data.groupName);
            } else {
                createPrivateGroup(globalUserId, userId);
            }
        })
        .catch(error => {
            console.error("Erreur lors de la vérification ou de la création du groupe privé", error);
        });

    closeModal();
}

function createPrivateGroup(userOneId, userTwoId) {
    axios.get(`/api/user-details/${userTwoId}`).then(response => {
        const otherUser = response.data;
        const groupName = `${otherUser.firstname} ${otherUser.lastname}`;

        axios.post('/create-group', {
            groupName: groupName,
            userIds: [userOneId, userTwoId]
        })
            .then(response => {
                joinGroupChat(response.data.group.id, groupName);
                loadUserConversation();
            })
            .catch(error => {
                console.error('Erreur lors de la création de la conversation privée', error);
            });
    }).catch(error => {
        console.error('Erreur lors de la récupération des informations de l\'utilisateur', error);
    });
}

function loadUserConversation() {
    loadUnreadMessagesCount().then(() => {
        axios.get('/api/user-groups?type=private')
            .then(response => {
                const groups = response.data.groups;
                const conversationsContainer = document.querySelector('.flex.flex-col.divide-y.h-full.overflow-y-auto.-mx-4');
                conversationsContainer.innerHTML = '';

                groups.forEach(group => {
                    const unreadCount = group.unreadMessagesCount;
                    const otherMember = group.members.find(member => member.id !== globalUserId);

                    const conversationElement = document.createElement('div');
                    conversationElement.classList.add('flex', 'flex-row', 'items-center', 'p-4', 'relative');
                    conversationElement.setAttribute('data-conversation-id', group.id);

                    const timeElement = document.createElement('div');
                    timeElement.classList.add('absolute', 'text-xs', 'text-gray-500', 'right-0', 'top-0', 'mr-4', 'mt-3');
                    timeElement.textContent = group.lastMessageTime || 'Un moment';
                    timeElement.setAttribute('data-last-message-time', group.id);

                    const iconElement = document.createElement('div');
                    iconElement.classList.add('flex', 'items-center', 'justify-center', 'h-10', 'w-10', 'rounded-full', 'bg-pink-500', 'text-pink-300', 'font-bold', 'flex-shrink-0');
                    iconElement.textContent = otherMember ? otherMember.firstname.charAt(0) : group.name.charAt(0);

                    const groupInfoElement = document.createElement('div');
                    groupInfoElement.classList.add('flex', 'flex-col', 'flex-grow', 'ml-3');
                    const groupNameElement = document.createElement('div');
                    groupNameElement.classList.add('text-sm', 'font-medium');
                    groupNameElement.textContent = otherMember ? `${otherMember.firstname} ${otherMember.lastname}` : 'Groupe inconnu';
                    const lastMessageElement = document.createElement('div');
                    lastMessageElement.classList.add('text-xs', 'truncate', 'w-40');
                    lastMessageElement.textContent = group.lastMessageContent || 'Pas de messages';
                    lastMessageElement.setAttribute('data-last-message', group.id);

                    const newMessagesElement = document.createElement('div');
                    newMessagesElement.classList.add('flex-shrink-0', 'ml-2', 'self-end', 'mb-1');
                    const messagesCountElement = document.createElement('span');
                    messagesCountElement.classList.add('flex', 'items-center', 'justify-center', 'h-5', 'w-5', 'bg-red-500', 'text-white', 'text-xs', 'rounded-full');
                    messagesCountElement.textContent = unreadCount || '';

                    groupInfoElement.appendChild(groupNameElement);
                    groupInfoElement.appendChild(lastMessageElement);
                    if (unreadCount > 0) {
                        newMessagesElement.appendChild(messagesCountElement);
                    }
                    conversationElement.appendChild(timeElement);
                    conversationElement.appendChild(iconElement);
                    conversationElement.appendChild(groupInfoElement);
                    conversationElement.appendChild(newMessagesElement);

                    conversationElement.addEventListener('click', () => joinGroupChat(group.id, groupNameElement.textContent));

                    conversationsContainer.appendChild(conversationElement);

                    subscribeToAllGroupChannelsPrivate(groups);
                });
            })
            .catch(error => console.error('Erreur lors du chargement des groupes', error));
    });
}

function triggerPushNotification(groupId, messageContent, globalUserId) {
    const notificationContent = messageContent || "Image";

    axios.post('/api/send-notification-group', {
        groupId: groupId,
        message: notificationContent,
        id_sender: globalUserId
    })
        .then(response => {
            console.log(notificationContent);
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error triggering notification', error);
        });
}

function startRefreshingConversations() {
    loadUserConversation();

    setInterval(() => {
        loadUserGroups();
        loadUserConversation();
        console.log("actualiser");
    }, 60000);
}

function subscribeToAllGroupChannels(groups) {
    groups.forEach(group => {
        if (!groupChannels[group.id]) {
            groupChannels[group.id] = window.Echo.private(`group.${group.id}`)
                .listen('GroupChatMessageEvent', (e) => {
                    console.log(e.message);
                    updateGroupPreview(group.id, e.message.content);
                });
        }
    });
}

function updateGroupPreview(groupId, messageContent) {
    const lastMessageElement = document.querySelector(`[data-last-message="${groupId}"]`);
    if (lastMessageElement) {
        lastMessageElement.textContent = messageContent || 'Nouveau message';
    }

    const lastMessageTimeElement = document.querySelector(`[data-last-message-time="${groupId}"]`);
    if (lastMessageTimeElement) {
        lastMessageTimeElement.textContent = new Date().toLocaleTimeString();
    }
}

function subscribeToAllGroupChannelsPrivate(groups) {
    groups.forEach(group => {
        if (!groupChannels[group.id]) {
            groupChannels[group.id] = window.Echo.private(`group.${group.id}`)
                .listen('GroupChatMessageEvent', (e) => {
                    console.log(e.message);
                    updateConversationPreview(group.id, e.message.content);
                });
        }
    });
}

function updateConversationPreview(conversationId) {
    loadUnreadMessagesCount().then(groupsWithUnreadCounts => {
        loadUserConversation();
        loadPreviousMessages(conversationId);

        const groupData = groupsWithUnreadCounts.find(group => group.id === conversationId);
        const unreadCount = groupData ? groupData.unreadMessagesCount : 0;

        const lastMessageElement = document.querySelector(`[data-conversation-id="${conversationId}"] [data-last-message]`);
        if (lastMessageElement) {
            lastMessageElement.textContent = groupData.lastMessageContent || 'Nouveau message';
        }

        const lastMessageTimeElement = document.querySelector(`[data-conversation-id="${conversationId}"] [data-last-message-time]`);
        if (lastMessageTimeElement) {
            lastMessageTimeElement.textContent = groupData.lastMessageTime || new Date().toLocaleTimeString();
        }

        const messagesCountElement = document.querySelector(`[data-conversation-id="${conversationId}"] .messages-count`);
        if (messagesCountElement) {
            if (unreadCount > 0) {
                messagesCountElement.textContent = unreadCount;
                messagesCountElement.classList.remove('hidden');
            } else {
                messagesCountElement.classList.add('hidden');
            }
        }

    }).catch(error => {
        console.error("Erreur lors du chargement du nombre de messages non lus:", error);
    });
}

function updateLastVisitedAt(groupId) {
    axios.post(`/api/groups/${groupId}/update-last-visited`)
        .then(response => {
            console.log("Dernière visite mise à jour pour le groupe:", groupId);
            loadUserConversation();
        })
        .catch(error => {
            console.error("Erreur lors de la mise à jour de la dernière visite:", error);
        });
}

function loadUnreadMessagesCount() {
    return new Promise((resolve, reject) => {
        axios.get('/api/user-groups')
            .then(response => {
                const groups = response.data.groups;
                const groupsWithUnreadCounts = groups.map(group => {
                    return {
                        id: group.id,
                        unreadMessagesCount: group.unreadMessagesCount,
                        lastMessageContent: group.lastMessageContent,
                        lastMessageTime: group.lastMessageTime,
                    };
                });

                resolve(groupsWithUnreadCounts);
            })
            .catch(error => {
                console.error("Erreur lors du chargement des groupes et du nombre de messages non lus:", error);
                reject(error);
            });
    });
}
