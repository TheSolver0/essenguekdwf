<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un don - Association Solidarité</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notchpay-js@latest/dist/notchpay.min.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #059669;
            --secondary-dark: #047857;
            --light-bg: #f0f9ff;
            --gray-bg: #f9fafb;
            --orange: #ff9800;
            --mtn-yellow: #ffcb05;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(120deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .form-section {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        .bg-blue {
            background-color: var(--light-bg);
            border-left: 4px solid var(--primary);
        }

        .bg-gray {
            background-color: var(--gray-bg);
            border-left: 4px solid #9ca3af;
        }

        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.25rem;
        }

        .amount-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 640px) {
            .amount-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .amount-btn {
            padding: 1rem;
            border: 2px solid #93c5fd;
            border-radius: 8px;
            background: white;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .amount-btn:hover {
            background: #dbeafe;
        }

        .amount-btn.selected {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #9ca3af;
        }

        .input-icon input {
            padding-left: 40px;
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 640px) {
            .payment-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .payment-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        .payment-method {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: var(--primary);
        }

        .payment-method.selected {
            border-color: var(--primary);
            background-color: var(--light-bg);
        }

        .payment-method.orange {
            border-color: var(--orange);
        }

        .payment-method.orange.selected {
            background-color: rgba(255, 152, 0, 0.1);
        }

        .payment-method.mtn {
            border-color: var(--mtn-yellow);
        }

        .payment-method.mtn.selected {
            background-color: rgba(255, 203, 5, 0.1);
        }

        .payment-method i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .payment-method.orange i {
            color: var(--orange);
        }

        .payment-method.mtn i {
            color: var(--mtn-yellow);
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 1rem;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: var(--secondary-dark);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .checkbox-group input {
            width: auto;
            margin-right: 10px;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .two-columns {
                grid-template-columns: 1fr 1fr;
            }
        }

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .security-note i {
            color: var(--secondary);
            margin-right: 0.5rem;
        }

        .mobile-money-info {
            display: none;
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .notchpay-btn {
            background: linear-gradient(120deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .notchpay-btn:hover {
            opacity: 0.9;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .modal-btn.confirm {
            background: var(--secondary);
            color: white;
        }

        .modal-btn.cancel {
            background: #e5e7eb;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1><i class="fas fa-hands-helping"></i> Faire un Don</h1>
                <p>Votre soutien permet de changer des vies. Chaque don compte.</p>
            </div>

            <div class="container" style="padding: 2rem;">
                <!-- Messages d'alerte -->
                <div id="alert-message" class="alert" style="display: none;"></div>

                <form id="donation-form" class="space-y-6">
                    <!-- Section Montant du don -->
                    <div class="form-section bg-blue">
                        <h3 class="section-title">
                            <i class="fas fa-euro-sign"></i>Montant du don
                        </h3>

                        <!-- Montants prédéfinis -->
                        <div class="amount-grid">
                            <button type="button" class="amount-btn" data-amount="1000">1 000 FCFA</button>
                            <button type="button" class="amount-btn" data-amount="2000">2 000 FCFA</button>
                            <button type="button" class="amount-btn" data-amount="5000">5 000 FCFA</button>
                            <button type="button" class="amount-btn" data-amount="10000">10 000 FCFA</button>
                        </div>

                        <!-- Montant personnalisé -->
                        <div class="form-group">
                            <label for="amount">Ou montant personnalisé (FCFA)</label>
                            <div class="input-icon">
                                <i class="fas fa-euro-sign"></i>
                                <input type="number" id="amount" name="amount" placeholder="0" min="100" step="100" required>
                            </div>
                        </div>
                    </div>

                    <!-- Section Informations personnelles -->
                    <div class="form-section bg-gray">
                        <h3 class="section-title">
                            <i class="fas fa-user-circle"></i>Vos informations
                        </h3>

                        <div class="two-columns">
                            <div class="form-group">
                                <label for="first_name">Prénom *</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Nom *</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Numéro de téléphone *</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ex: +225 07 07 07 07 07" required>
                        </div>

                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="newsletter" name="newsletter">
                            <label for="newsletter">Je souhaite recevoir les actualités de l'association</label>
                        </div>
                    </div>

                    <!-- Section Paiement -->
                    <div class="form-section bg-blue">
                        <h3 class="section-title">
                            <i class="fas fa-credit-card"></i>Moyen de paiement
                        </h3>

                        <!-- Options de paiement -->
                        <div class="payment-grid">
                            <label class="payment-method selected" data-method="card">
                                <input type="radio" name="payment_method" value="card" checked style="display: none;">
                                <i class="fas fa-credit-card"></i>
                                <p class="font-medium">Carte bancaire</p>
                            </label>

                            <label class="payment-method" data-method="paypal">
                                <input type="radio" name="payment_method" value="paypal" style="display: none;">
                                <i class="fab fa-paypal"></i>
                                <p class="font-medium">PayPal</p>
                            </label>

                            <label class="payment-method orange" data-method="orange_money">
                                <input type="radio" name="payment_method" value="orange_money" style="display: none;">
                                <i class="fas fa-mobile-alt"></i>
                                <p class="font-medium">Orange Money</p>
                            </label>

                            <label class="payment-method mtn" data-method="mtn_money">
                                <input type="radio" name="payment_method" value="mtn_money" style="display: none;">
                                <i class="fas fa-mobile-alt"></i>
                                <p class="font-medium">MTN Money</p>
                            </label>

                            <label class="payment-method" data-method="transfer">
                                <input type="radio" name="payment_method" value="transfer" style="display: none;">
                                <i class="fas fa-university"></i>
                                <p class="font-medium">Virement</p>
                            </label>
                        </div>

                        <!-- Informations carte (affiché par défaut) -->
                        <div id="card-info">
                            <div class="two-columns">
                                <div class="form-group">
                                    <label for="card_number">Numéro de carte *</label>
                                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="form-group">
                                    <label for="cvv">Cryptogramme *</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="123">
                                </div>
                            </div>

                            <div class="two-columns">
                                <div class="form-group">
                                    <label for="expiry_date">Date d'expiration *</label>
                                    <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/AA">
                                </div>
                                <div class="form-group">
                                    <label for="card_holder">Titulaire de la carte *</label>
                                    <input type="text" id="card_holder" name="card_holder" placeholder="Nom Prénom">
                                </div>
                            </div>
                        </div>

                        <!-- Informations pour mobile money -->
                        <div id="mobile-money-info" class="mobile-money-info">
                            <p><i class="fas fa-info-circle"></i> Après avoir soumis le formulaire, vous serez redirigé vers NotchPay pour finaliser votre paiement via mobile money.</p>
                        </div>
                    </div>

                    <!-- Mentions légales -->
                    <div class="security-note">
                        <i class="fas fa-lock"></i>
                        <p>Vos informations sont sécurisées et cryptées. Les dons à notre association ouvrent droit à une réduction d'impôt de 66% de leur montant.</p>
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-heart"></i> Faire un don sécurisé
                    </button>

                    <!-- Loader -->
                    <div id="loader" class="loader"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour NotchPay -->
    <div id="notchpay-modal" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-external-link-alt"></i> Redirection vers NotchPay</h3>
            <p>Vous allez être redirigé vers NotchPay pour finaliser votre paiement. Cliquez sur "Confirmer" pour continuer.</p>
            <div class="modal-buttons">
                <button class="modal-btn cancel" id="cancel-payment">Annuler</button>
                <button class="modal-btn confirm" id="confirm-payment">Confirmer</button>
            </div>
        </div>
    </div>

    <script>
        // Configuration de NotchPay - REMPLACEZ par votre clé publique
        const NOTCHPAY_PUBLIC_KEY = 'pk_test.weaKZT9YdpOWqXsJlI0oeWB2V5ZlkXxJrvyWBoPV7hczLPca6t0s544UUvsrECQOidLUotTEEqYooAJRefQ6TROUh1zzB52RPk1SBi2IJhUbWDqC5GSkJgava3DSM';

        const NotchPay = new NotchPay('NOTCHPAY_PUBLIC_KEY');

        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser NotchPay avec votre clé publique
            NotchPay.setPublishableKey(NOTCHPAY_PUBLIC_KEY);

            // Gestion des boutons de montant
            const amountButtons = document.querySelectorAll('.amount-btn');
            const amountInput = document.getElementById('amount');

            amountButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Retirer la sélection précédente
                    amountButtons.forEach(btn => btn.classList.remove('selected'));

                    // Sélectionner le bouton cliqué
                    button.classList.add('selected');

                    // Mettre à jour l'input avec la valeur
                    amountInput.value = button.getAttribute('data-amount');
                });
            });

            // Gestion de la sélection de la méthode de paiement
            const paymentMethods = document.querySelectorAll('.payment-method');
            const cardInfo = document.getElementById('card-info');
            const mobileMoneyInfo = document.getElementById('mobile-money-info');

            paymentMethods.forEach(method => {
                method.addEventListener('click', () => {
                    // Retirer la sélection précédente
                    paymentMethods.forEach(m => m.classList.remove('selected'));

                    // Sélectionner la méthode cliquée
                    method.classList.add('selected');

                    // Mettre à jour le radio button
                    const radio = method.querySelector('input[type="radio"]');
                    radio.checked = true;

                    // Afficher/masquer les infos de carte et mobile money
                    const methodValue = radio.value;

                    if (methodValue === 'card') {
                        cardInfo.style.display = 'block';
                        mobileMoneyInfo.style.display = 'none';
                    } else if (methodValue === 'orange_money' || methodValue === 'mtn_money') {
                        cardInfo.style.display = 'none';
                        mobileMoneyInfo.style.display = 'block';
                    } else {
                        cardInfo.style.display = 'none';
                        mobileMoneyInfo.style.display = 'none';
                    }
                });
            });

            // Gestion de la soumission du formulaire
            const donationForm = document.getElementById('donation-form');
            const alertMessage = document.getElementById('alert-message');
            const loader = document.getElementById('loader');
            const notchpayModal = document.getElementById('notchpay-modal');
            const confirmPaymentBtn = document.getElementById('confirm-payment');
            const cancelPaymentBtn = document.getElementById('cancel-payment');

            let formData = {};

            donationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Récupération des données du formulaire
                formData = {
                    amount: document.getElementById('amount').value,
                    first_name: document.getElementById('first_name').value,
                    last_name: document.getElementById('last_name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    newsletter: document.getElementById('newsletter').checked,
                    payment_method: document.querySelector('input[name="payment_method"]:checked').value,
                    card_number: document.getElementById('card_number')?.value,
                    cvv: document.getElementById('cvv')?.value,
                    expiry_date: document.getElementById('expiry_date')?.value,
                    card_holder: document.getElementById('card_holder')?.value
                };

                // Validation basique
                if (!formData.amount || formData.amount < 100) {
                    showAlert('Veuillez entrer un montant valide (au moins 100 FCFA)', 'error');
                    return;
                }

                const paymentMethod = formData.payment_method;

                if (paymentMethod === 'orange_money' || paymentMethod === 'mtn_money') {
                    // Afficher la modal de confirmation pour NotchPay
                    notchpayModal.style.display = 'flex';
                } else {
                    // Pour les autres méthodes de paiement, traiter normalement
                    processDonation(formData);
                }
            });

            // Confirmation de paiement avec NotchPay
            confirmPaymentBtn.addEventListener('click', function() {
                notchpayModal.style.display = 'none';
                processNotchPayPayment(formData);
            });

            // Annulation du paiement
            cancelPaymentBtn.addEventListener('click', function() {
                notchpayModal.style.display = 'none';
            });

            // Fonction pour traiter le paiement avec NotchPay
            function processNotchPayPayment(formData) {
                loader.style.display = 'block';

                // Configurer les détails de la transaction
                const transactionData = {
                    amount: formData.amount,
                    currency: 'XOF',
                    description: 'Don à une association caritative',
                    channels: [formData.payment_method],
                    customer: {
                        name: `${formData.first_name} ${formData.last_name}`,
                        email: formData.email,
                        phone: formData.phone.replace(/\s+/g, '') // Supprimer les espaces
                    },
                    metadata: {
                        donateur: `${formData.first_name} ${formData.last_name}`,
                        email: formData.email,
                        type: 'don'
                    }
                };

                // Créer la transaction avec NotchPay
                NotchPay.createTransaction(transactionData,
                    function(response) {
                        loader.style.display = 'none';

                        if (response && response.transaction && response.transaction.url) {
                            // Rediriger l'utilisateur vers la page de paiement NotchPay
                            window.location.href = response.transaction.url;
                        } else {
                            showAlert('Erreur lors de la création de la transaction. Veuillez réessayer.', 'error');
                        }
                    },
                    function(error) {
                        loader.style.display = 'none';
                        console.error('Erreur NotchPay:', error);
                        showAlert('Une erreur est survenue lors de l\'initialisation du paiement: ' +
                                 (error.message || 'Veuillez réessayer'), 'error');
                    }
                );
            }

            // Fonction pour traiter les autres types de dons
            function processDonation(formData) {
                loader.style.display = 'block';

                // Simuler un délai de traitement
                setTimeout(() => {
                    loader.style.display = 'none';
                    showAlert('Merci pour votre don de ' + formData.amount + ' FCFA ! Un email de confirmation a été envoyé.', 'success');

                    // Réinitialiser le formulaire
                    donationForm.reset();
                }, 2000);
            }

            // Fonction pour afficher les messages d'alerte
            function showAlert(message, type) {
                alertMessage.textContent = message;
                alertMessage.className = 'alert';
                alertMessage.classList.add(type === 'error' ? 'alert-error' : 'alert-success');
                alertMessage.style.display = 'block';

                // Masquer l'alerte après 5 secondes
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 5000);
            }

            // Gestion de la réponse de NotchPay après retour de paiement
            const urlParams = new URLSearchParams(window.location.search);
            const paymentStatus = urlParams.get('status');

            if (paymentStatus === 'success') {
                showAlert('Votre paiement a été effectué avec succès. Merci pour votre don !', 'success');
            } else if (paymentStatus === 'failed') {
                showAlert('Votre paiement a échoué. Veuillez réessayer.', 'error');
            }
        });
    </script>
</body>
</html>
