<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Royal Caribbean Investment - Invest. Trade. Prosper.')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    <style>
        /* Homepage popup banner (like your screenshot) */
        .sitePopup {
            position: fixed;
            left: 50%;
            bottom: 16px;
            transform: translateX(-50%);
            z-index: 9999;
            max-width: 340px;
            width: calc(100vw - 32px);
            background: #0b0c10;
            color: #fff;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .14);
            box-shadow: 0 18px 45px rgba(0, 0, 0, .35);
            padding: 12px 12px;
            display: none;
        }

        .sitePopup.show {
            display: block;
        }

        .sitePopupTop {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: start;
        }

        .sitePopupTitle {
            font-size: 13px;
            font-weight: 900;
            margin: 0;
        }

        .sitePopupMsg {
            margin-top: 2px;
            font-size: 13px;
            font-weight: 700;
            color: rgba(255, 255, 255, .82);
            line-height: 1.35;
        }

        .sitePopupAmt {
            font-size: 15px;
            font-weight: 900;
            color: #ffffff;
        }

        .sitePopupClose {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            color: #fff;
            cursor: pointer;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .sitePopupClose:hover {
            background: rgba(255, 255, 255, .10);
        }

        @media (max-width: 480px) {
            .sitePopup {
                left: 50%;
                bottom: 12px;
                transform: translateX(-50%);
                width: calc(100vw - 24px);
            }
        }
    </style>

</head>

<body>
    @include('layouts.header')

    @include('layouts.mobile-menu')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    @include('layouts.scripts')

    <!-- Homepage popup banner -->
    <div class="sitePopup" id="sitePopup" aria-live="polite" aria-atomic="true">
        <div class="sitePopupTop">
            <div style="min-width:0;">
                <div class="sitePopupTitle" id="sitePopupTitle">Earning</div>
                <div class="sitePopupMsg" id="sitePopupMsg">Someone just earned $100</div>
            </div>
            <button type="button" class="sitePopupClose" id="sitePopupClose" aria-label="Close">✕</button>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Homepage rotating popup (fake activity like screenshot)
        (function () {
            const popup = document.getElementById('sitePopup');
            const titleEl = document.getElementById('sitePopupTitle');
            const msgEl = document.getElementById('sitePopupMsg');
            const closeBtn = document.getElementById('sitePopupClose');
            if (!popup || !titleEl || !msgEl || !closeBtn) return;

            const names = ['William', 'Sophia', 'Daniel', 'Amina', 'Noah', 'Olivia', 'Ethan', 'Mia', 'James', 'Fatima'];
            const countries = ['USA', 'CANADA', 'UK', 'GERMANY', 'NIGERIA', 'PAKISTAN', 'UAE', 'SOUTH AFRICA', 'INDIA', 'FRANCE'];

            function rand(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }
            function money(min, max) { return '$' + rand(min, max).toLocaleString('en-US'); }

            const templates = [
                () => ({ title: 'Earning', msg: `${names[rand(0, names.length-1)]} from ${countries[rand(0, countries.length-1)]} has just earned ${money(120, 8200)}` }),
                () => ({ title: 'Deposit', msg: `A user just deposited ${money(50, 5000)}` }),
                () => ({ title: 'Withdrawal', msg: `A user just requested a withdrawal of ${money(50, 7000)}` }),
                () => ({ title: 'Purchase', msg: `A user just purchased an item worth ${money(200, 12000)}` }),
            ];

            let closed = false;
            closeBtn.addEventListener('click', function () {
                closed = true;
                popup.classList.remove('show');
            });

            function showOnce() {
                if (closed) return;
                const t = templates[rand(0, templates.length-1)]();
                titleEl.textContent = t.title;
                // emphasize the amount (first $... pattern)
                msgEl.innerHTML = String(t.msg).replace(/(\$[0-9][0-9,]*)/, '<span class="sitePopupAmt">$1</span>');
                popup.classList.add('show');
                setTimeout(() => popup.classList.remove('show'), 9000);
            }

            // first popup after a short delay, then rotate
            setTimeout(showOnce, 2500);
            setInterval(showOnce, 20000);
        })();
    </script>
</body>

</html>