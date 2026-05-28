<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Invited — {{ $event->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: #f0f4ff;
            color: #1e293b;
            padding: 32px 16px;
        }
        .wrapper {
            max-width: 580px;
            margin: 0 auto;
        }
        /* Logo Header */
        .logo-bar {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo-bar span {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
        }
        .logo-icon {
            display: inline-flex;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 10px;
            align-items: center;
            justify-content: center;
        }
        .logo-icon svg { color: white; }
        .brand-color { color: #6366f1; }

        /* Hero Card */
        .card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(99,102,241,0.08);
        }
        .hero {
            background: linear-gradient(135deg, #312e81 0%, #4f46e5 40%, #7c3aed 100%);
            padding: 48px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #c7d2fe;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 100px;
            padding: 6px 16px;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .hero p {
            font-size: 15px;
            color: rgba(255,255,255,0.75);
        }
        .confetti {
            font-size: 32px;
            margin-bottom: 16px;
            display: block;
        }

        /* Body Content */
        .body {
            padding: 40px;
        }
        .greeting {
            font-size: 17px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .body > p {
            font-size: 15px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        /* Event Details Card */
        .details {
            background: #f8faff;
            border: 1px solid #e0e7ff;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 32px;
        }
        .details h3 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6366f1;
            margin-bottom: 16px;
        }
        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #ede9fe;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
        }
        .detail-content .label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .detail-content .value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-top: 1px;
        }

        /* CTA Button */
        .cta-wrap {
            text-align: center;
            margin-bottom: 32px;
        }
        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            padding: 16px 40px;
            border-radius: 12px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 20px rgba(99,102,241,0.35);
        }
        .cta-sub {
            margin-top: 12px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Divider */
        hr {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 28px 0;
        }

        /* Link fallback */
        .link-fallback {
            background: #f8faff;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 12px;
            color: #64748b;
            word-break: break-all;
        }
        .link-fallback a {
            color: #6366f1;
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 24px 40px;
            border-top: 1px solid #f1f5f9;
            background: #fafbff;
        }
        .footer p {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer strong { color: #6366f1; }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Logo -->
        <div class="logo-bar">
            <span>
                <span class="logo-icon">
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                Event<span class="brand-color">Ease</span>
            </span>
        </div>

        <!-- Main Card -->
        <div class="card">

            <!-- Hero -->
            <div class="hero">
                <span class="confetti">🎉</span>
                <div class="hero-badge">Personal Invitation</div>
                <h1>You're Invited to<br>{{ $event->title }}</h1>
                <p>We'd love to celebrate with you!</p>
            </div>

            <!-- Body -->
            <div class="body">
                <p class="greeting">Dear {{ $guest->name }},</p>
                <p>
                    You have been personally invited to attend <strong>{{ $event->title }}</strong>.
                    We are thrilled to have you join us and make this occasion truly memorable.
                    Please take a moment to confirm your attendance using the button below.
                </p>

                <!-- Event Details -->
                <div class="details">
                    <h3>Event Details</h3>

                    <div class="detail-row">
                        <div class="detail-icon">📅</div>
                        <div class="detail-content">
                            <div class="label">Date</div>
                            <div class="value">{{ \Carbon\Carbon::parse($event->event_date)->format('l, F d, Y') }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon">📍</div>
                        <div class="detail-content">
                            <div class="label">Venue</div>
                            <div class="value">{{ $event->location }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon">🎭</div>
                        <div class="detail-content">
                            <div class="label">Event Type</div>
                            <div class="value">{{ $event->event_type }}</div>
                        </div>
                    </div>

                    @if($event->description)
                    <div class="detail-row">
                        <div class="detail-icon">📝</div>
                        <div class="detail-content">
                            <div class="label">Note from Host</div>
                            <div class="value">{{ $event->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- CTA -->
                <div class="cta-wrap">
                    <a href="{{ $rsvpUrl }}" class="cta-btn">✅ &nbsp;Confirm My Attendance</a>
                    <p class="cta-sub">Click above to RSVP — it only takes 10 seconds</p>
                </div>

                <hr>

                <!-- Link Fallback -->
                <p style="font-size:13px;color:#64748b;margin-bottom:10px;">
                    If the button doesn't work, copy and paste this link into your browser:
                </p>
                <div class="link-fallback">
                    <a href="{{ $rsvpUrl }}">{{ $rsvpUrl }}</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>
                    This invitation was sent via <strong>EventEase</strong>.<br>
                    If you believe you received this by mistake, you can safely ignore this email.
                </p>
            </div>

        </div>

    </div>
</body>
</html>
