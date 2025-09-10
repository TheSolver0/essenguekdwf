@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://checkout.flutterwave.com/v3.js"></script>
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
            --flutterwave-blue: #2d66fe;
        }



        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin: 20px 0;
        }

        .header {
            background: linear-gradient(120deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 2.5rem;
            text-align: center;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--mtn-yellow), var(--flutterwave-blue));
        }

        .header h1 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .form-content {
            padding: 2rem;
        }

        .form-section {
            padding: 1.8rem;
            margin-bottom: 1.8rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
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
            margin-bottom: 1.8rem;
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 1.3rem;
        }

        .section-title i {
            margin-right: 12px;
            font-size: 1.4rem;
        }

        .amount-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 1.8rem;
        }

        @media (min-width: 640px) {
            .amount-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .amount-btn {
            padding: 1.2rem;
            border: 2px solid #93c5fd;
            border-radius: 10px;
            background: white;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1.1rem;
        }

        .amount-btn:hover {
            background: #dbeafe;
            transform: translateY(-2px);
        }

        .amount-btn.selected {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: #374151;
            font-size: 1.05rem;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .input-icon input {
            padding-left: 50px;
        }

        input,
        select {
            width: 100%;
            padding: 0.9rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 1.05rem;
            transition: all 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 15px;
            margin-bottom: 1.8rem;
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
            border-radius: 10px;
            padding: 1.8rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .payment-method:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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

        .payment-method.flutterwave {
            border-color: var(--flutterwave-blue);
        }

        .payment-method.flutterwave.selected {
            background-color: rgba(45, 102, 254, 0.1);
        }

        .payment-method i {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
        }

        .payment-method.orange i {
            color: var(--orange);
        }

        .payment-method.mtn i {
            color: var(--mtn-yellow);
        }

        .payment-method.flutterwave i {
            color: var(--flutterwave-blue);
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 1.2rem;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1.5rem;
            box-shadow: 0 5px 15px rgba(5, 150, 105, 0.3);
        }

        .btn-submit:hover {
            background: var(--secondary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
        }

        .checkbox-group input {
            width: auto;
            margin-right: 12px;
            transform: scale(1.2);
        }

        .alert {
            padding: 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
        }

        .alert i {
            margin-right: 12px;
            font-size: 1.5rem;
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

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.2rem;
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
            margin-top: 2rem;
            color: #6b7280;
            font-size: 1rem;
            text-align: center;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 10px;
        }

        .security-note i {
            color: var(--secondary);
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        .mobile-money-info {
            display: none;
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 1.2rem;
            border-radius: 10px;
            margin-top: 1.5rem;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 1.5rem auto;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .flutterwave-btn {
            background: linear-gradient(120deg, var(--flutterwave-blue), #5590ff);
            color: white;
            border: none;
            padding: 1rem 1.8rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 1.5rem;
            transition: all 0.3s;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(45, 102, 254, 0.3);
        }

        .flutterwave-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 102, 254, 0.4);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalAppear 0.3s ease-out;
        }

        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-buttons {
            display: flex;
            gap: 1.2rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .modal-btn {
            padding: 0.9rem 1.8rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 1.05rem;
        }

        .modal-btn.confirm {
            background: var(--secondary);
            color: white;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        }

        .modal-btn.confirm:hover {
            background: var(--secondary-dark);
            transform: translateY(-2px);
        }

        .modal-btn.cancel {
            background: #e5e7eb;
            color: #4b5563;
        }

        .modal-btn.cancel:hover {
            background: #d1d5db;
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 1.5rem 0;
            flex-wrap: wrap;
        }

        .logo {
            height: 40px;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .logo:hover {
            opacity: 1;
        }

        .instructions {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .instructions h2 {
            color: var(--primary);
            margin-bottom: 1rem;
            text-align: center;
        }

        .instructions ol {
            padding-left: 1.5rem;
            line-height: 1.8;
        }

        .instructions li {
            margin-bottom: 0.8rem;
        }

        .instructions code {
            background: #f3f4f6;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-family: monospace;
        }
    </style>

        <div class="container">
            <div class="card">
                <div class="header">
                    <h1><i class="fas fa-hands-helping"></i> Faire un Don</h1>
                    <p>Votre soutien permet de changer des vies. Chaque don compte.</p>
                </div>

                <div class="form-content">
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
                                    <input type="number" id="amount" name="amount" placeholder="0" min="100"
                                        step="100" required>
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
                                <input type="tel" id="phone" name="phone" placeholder="Ex: +2250707070707"
                                    required>
                            </div>

                            <div class="checkbox-group">
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
                                    <input type="radio" name="payment_method" value="card" checked
                                        style="display: none;">
                                    <i class="fas fa-credit-card"></i>
                                    <p class="font-medium">Carte bancaire</p>
                                </label>

                                <label class="payment-method" data-method="paypal">
                                    <input type="radio" name="payment_method" value="paypal" style="display: none;">
                                    <i class="fab fa-paypal"></i>
                                    <p class="font-medium">PayPal</p>
                                </label>

                                <label class="payment-method orange" data-method="mobile_money">
                                    <input type="radio" name="payment_method" value="mobile_money" style="display: none;">
                                    <i class="fas fa-mobile-alt"></i>
                                    <p class="font-medium">Mobile Money</p>
                                </label>

                                <label class="payment-method flutterwave" data-method="flutterwave">
                                    <input type="radio" name="payment_method" value="flutterwave"
                                        style="display: none;">
                                    <i class="fas fa-wallet"></i>
                                    <p class="font-medium">Flutterwave</p>
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
                                        <input type="text" id="card_number" name="card_number"
                                            placeholder="1234 5678 9012 3456">
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
                                        <input type="text" id="card_holder" name="card_holder"
                                            placeholder="Nom Prénom">
                                    </div>
                                </div>
                            </div>

                            <!-- Informations pour mobile money -->
                            <div id="mobile-money-info" class="mobile-money-info">
                                <p><i class="fas fa-info-circle"></i> Après avoir soumis le formulaire, vous serez redirigé
                                    vers Flutterwave pour finaliser votre paiement via mobile money.</p>
                            </div>
                        </div>

                        <!-- Mentions légales -->
                        <div class="security-note">
                            <i class="fas fa-lock"></i>
                            <p>Vos informations sont sécurisées et cryptées. Les dons à notre association ouvrent droit à
                                une réduction d'impôt de 66% de leur montant.</p>
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

        <!-- Modal de confirmation pour Flutterwave -->
        <div id="flutterwave-modal" class="modal">
            <div class="modal-content">
                <h3><i class="fas fa-external-link-alt"></i> Redirection vers Flutterwave</h3>
                <p>Vous allez être redirigé vers Flutterwave pour finaliser votre paiement. Cliquez sur "Confirmer" pour
                    continuer.</p>
                <div class="modal-buttons">
                    <button class="modal-btn cancel" id="cancel-payment">Annuler</button>
                    <button class="modal-btn confirm" id="confirm-payment">Confirmer</button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configuration de Flutterwave - REMPLACEZ par votre clé publique
                const FLUTTERWAVE_PUBLIC_KEY = 'FLWPUBK_TEST-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-X';

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
                        } else if (methodValue === 'mobile_money' || methodValue === 'flutterwave') {
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
                const flutterwaveModal = document.getElementById('flutterwave-modal');
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
                        payment_method: document.querySelector('input[name="payment_method"]:checked')
                            .value,
                        card_number: document.getElementById('card_number')?.value,
                        cvv: document.getElementById('cvv')?.value,
                        expiry_date: document.getElementById('expiry_date')?.value,
                        card_holder: document.getElementById('card_holder')?.value
                    };

                    console.log("Entries Data: ",formData);

                    // Validation basique
                    if (!formData.amount || formData.amount < 100) {
                        showAlert('Veuillez entrer un montant valide (au moins 100 FCFA)', 'error');
                        return;
                    }

                    const paymentMethod = formData.payment_method;

                    if (paymentMethod === 'mobile_money' || paymentMethod === 'flutterwave') {
                        // Afficher la modal de confirmation pour Flutterwave
                        flutterwaveModal.style.display = 'flex';
                    } else {
                        // Pour les autres méthodes de paiement, traiter normalement
                        processDonation(formData);
                    }
                });

                // Confirmation de paiement avec Flutterwave
                confirmPaymentBtn.addEventListener('click', function() {
                    flutterwaveModal.style.display = 'none';
                    processFlutterwavePayment(formData);
                    // makeFlutterwavePayment(formData);
                });

                // Annulation du paiement
                cancelPaymentBtn.addEventListener('click', function() {
                    flutterwaveModal.style.display = 'none';
                });

                // Fonction pour traiter le paiement avec Flutterwave
                function processFlutterwavePayment(formData) {
                    loader.style.display = 'block';

                    // Simulation d'un appel à l'API Flutterwave
                    setTimeout(() => {
                        loader.style.display = 'none';

                        // Dans une implémentation réelle, vous utiliseriez le code suivant:
                        makeFlutterwavePayment({
                            public_key: FLUTTERWAVE_PUBLIC_KEY,
                            tx_ref: "donation-" + Date.now(),
                            amount: formData.amount,
                            currency: "XOF",
                            payment_options: "mobilemoney",
                            redirect_url: "https://votresite.com/confirmation",
                            customer: {
                                email: formData.email,
                                phone_number: formData.phone,
                                name: formData.first_name + " " + formData.last_name
                            },
                            customizations: {
                                title: "Don Association Solidarité",
                                description: "Faire un don à notre association",
                                logo: "https://votresite.com/logo.png"
                            }
                        });

                        // Pour la démonstration, nous simulons une redirection réussie
                        showAlert(
                            'Redirection vers Flutterwave simulée avec succès. Dans une implémentation réelle, vous seriez redirigé vers la page de paiement.',
                            'info');

                        // Réinitialiser le formulaire après 3 secondes
                        setTimeout(() => {
                            donationForm.reset();
                            document.querySelectorAll('.amount-btn').forEach(btn => btn.classList
                                .remove('selected'));
                            document.querySelector('.payment-method').click(); // Reset to card
                        }, 3000);

                    }, 1500);
                }

                // Fonction pour traiter les autres types de dons
                function processDonation(formData) {
                    loader.style.display = 'block';

                    // Simuler un délai de traitement
                    setTimeout(() => {
                        loader.style.display = 'none';
                        showAlert('Merci pour votre don de ' + formData.amount +
                            ' FCFA ! Un email de confirmation a été envoyé.', 'success');

                        // Réinitialiser le formulaire
                        donationForm.reset();
                        document.querySelectorAll('.amount-btn').forEach(btn => btn.classList.remove(
                            'selected'));
                        document.querySelector('.payment-method').click(); // Reset to card
                    }, 2000);
                }

                // Fonction pour afficher les messages d'alerte
                function showAlert(message, type) {
                    alertMessage.innerHTML =
                        `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i> ${message}`;
                    alertMessage.className = 'alert';
                    alertMessage.classList.add(type === 'error' ? 'alert-error' : type === 'success' ? 'alert-success' :
                        'alert-info');
                    alertMessage.style.display = 'flex';

                    // Masquer l'alerte après 5 secondes
                    setTimeout(() => {
                        alertMessage.style.display = 'none';
                    }, 5000);
                }

                // Fonction pour initialiser le paiement Flutterwave (à utiliser en production)
                function makeFlutterwavePayment(paymentData) {
                    // Cette fonction sera appelée pour lancer le paiement Flutterwave
                    FlutterwaveCheckout({
                        public_key: paymentData.public_key,
                        tx_ref: paymentData.tx_ref,
                        amount: paymentData.amount,
                        currency: paymentData.currency,
                        payment_options: paymentData.payment_options,
                        redirect_url: paymentData.redirect_url,
                        customer: paymentData.customer,
                        customizations: paymentData.customizations,
                        callback: function(response) {
                            // Gérer la réponse du paiement
                            if (response.status === 'successful') {
                                showAlert('Paiement réussi! Merci pour votre don.', 'success');
                            } else {
                                showAlert('Le paiement a échoué. Veuillez réessayer.', 'error');
                            }
                        },
                        onclose: function() {
                            showAlert('Paiement annulé.', 'info');
                        }
                    });
                }
            });
        </script>
    @endsection
