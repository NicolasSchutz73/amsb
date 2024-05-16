document.addEventListener('DOMContentLoaded', function () {
    // Sélectionne tous les boutons d'équipe et les éléments de détails de l'équipe
    const teamButtons = document.querySelectorAll('.team-button');
    const teamDetails = document.querySelectorAll('.team-details');
    const tabButtons = document.querySelectorAll('.tab-button');
    const modalOverlay = document.getElementById('modal-overlay');

    // Ajoute un gestionnaire d'événements 'click' à chaque bouton d'équipe
    teamButtons.forEach((button, index) => {
        button.addEventListener('click', function () {
            // Pour chaque ensemble de détails de l'équipe
            teamDetails.forEach((details, idx) => {
                if (index === idx) {
                    // Affiche les détails de l'équipe correspondant au bouton cliqué
                    details.classList.remove('invisible');
                    details.classList.add('visible');
                    // Affiche l'onglet actif pour cette équipe avec un léger délai
                    const activeTabContent = details.querySelector('.tab-content.visible');
                    if (activeTabContent) {
                        activeTabContent.classList.remove('invisible');
                        setTimeout(() => activeTabContent.classList.add('visible'), 50);
                    } else {
                        const defaultTabContent = details.querySelector('.tab-content');
                        defaultTabContent.classList.remove('invisible');
                        setTimeout(() => defaultTabContent.classList.add('visible'), 50);
                    }
                } else {
                    // Cache les autres détails de l'équipe
                    details.classList.remove('visible');
                    details.classList.add('invisible');
                    details.querySelectorAll('.tab-content').forEach(content => content.classList.remove('visible'));
                }
            });
            // Active visuellement le bouton d'équipe cliqué et désactive les autres
            teamButtons.forEach(btn => btn.classList.remove('active-team'));
            button.classList.add('active-team');
        });
    });

    // Ajoute un gestionnaire d'événements 'click' à chaque bouton d'onglet
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Récupère l'ID cible de l'onglet à afficher
            const target = this.dataset.target;
            const parent = this.closest('.team-details');
            // Désactive tous les boutons d'onglet
            parent.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            // Cache tout le contenu des onglets
            parent.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('visible');
                content.classList.add('invisible');
            });
            // Active visuellement le bouton d'onglet cliqué
            this.classList.add('active');
            // Affiche le contenu de l'onglet cible après un léger délai
            const targetContent = parent.querySelector('#' + target);
            setTimeout(() => {
                targetContent.classList.remove('invisible');
                setTimeout(() => targetContent.classList.add('visible'), 50);
            }, 50);
        });
    });

    // Définit l'équipe et l'onglet par défaut comme actifs lors du chargement de la page
    if (document.querySelector('.team-button')) {
        document.querySelector('.team-button').click();
    }
    if (document.querySelector('.tab-button')) {
        document.querySelector('.tab-button').click();
    }

    // Gestion des modals
    const modalToggles = document.querySelectorAll('[data-modal-toggle]');
    const modals = document.querySelectorAll('[data-modal-hide]');

    modalToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const modalId = toggle.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden-teams');
                modal.classList.add('flex');
                modalOverlay.classList.remove('hidden-teams');
                modalOverlay.classList.add('flex');
            }
        });
    });

    modals.forEach(hide => {
        hide.addEventListener('click', function () {
            const modalId = hide.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden-teams');
                modalOverlay.classList.remove('flex');
                modalOverlay.classList.add('hidden-teams');
            }
        });
    });
});
