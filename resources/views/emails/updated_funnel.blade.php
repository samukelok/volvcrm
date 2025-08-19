<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Funnel Updated - {{ $funnel->title }}</title>

    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->

    <style type="text/css">
        /* Reset and base styles */
        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Mobile responsive */
        @media screen and (max-width: 600px) {
            .mobile-padding {
                padding: 20px !important;
            }

            .mobile-center {
                text-align: center !important;
            }

            .mobile-width {
                width: 100% !important;
                max-width: 100% !important;
            }

            .mobile-hide {
                display: none !important;
            }

            .mobile-stack {
                display: block !important;
                width: 100% !important;
            }

            .mobile-text-sm {
                font-size: 14px !important;
            }
        }

        /* Hover effects */
        .cta-button:hover {
            background-color: #1d4ed8 !important;
            transform: translateY(-1px);
        }

        .info-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        /* Status badge styles */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-updated {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
        }
    </style>
</head>

<body style="background-color: #f8fafc; margin: 0 !important; padding: 0 !important;">

    <!-- Preheader text -->
    <div
        style="display: none; font-size: 1px; color: #f8fafc; line-height: 1px; font-family: sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        Your funnel "{{ $funnel->title }}" has been updated with new changes.
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- Header spacer -->
        <tr>
            <td style="padding: 40px 0 0 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center">
                            <!-- Main container -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px;"
                                class="mobile-width">

                                <!-- Header with logo and brand -->
                                <tr>
                                    <td align="center" style="padding: 0 20px 30px 20px;" class="mobile-padding">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td align="center"
                                                    style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); border-radius: 16px; padding: 30px; position: relative;">
                                                    <!-- VolvCRM Logo -->
                                                    <div
                                                        style="width: 60px; height: 60px; background: #3814ff; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3 3V21L12 17L21 21V3H3Z" stroke="#3B82F6"
                                                                stroke-width="2" stroke-linejoin="round" />
                                                            <path d="M12 7V13" stroke="#3B82F6" stroke-width="2"
                                                                stroke-linecap="round" />
                                                            <path d="M9 10L12 13L15 10" stroke="#3B82F6"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>

                                                    <!-- Status badge -->
                                                    <div style="margin-bottom: 16px;">
                                                        <span class="status-badge status-updated">Funnel Updated</span>
                                                    </div>

                                                    <h1
                                                        style="color: #ffffff; font-size: 28px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.2;">
                                                        {{ $funnel->title }}</h1>
                                                    <p
                                                        style="color: #e2e8f0; font-size: 16px; margin: 0; line-height: 1.5;">
                                                        Your funnel has been successfully updated</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Greeting -->
                                <tr>
                                    <td style="padding: 0 20px;" class="mobile-padding">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            style="background: #ffffff; border-radius: 16px 16px 0 0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                                            <tr>
                                                <td style="padding: 30px 40px 20px 40px;">
                                                    <h2
                                                        style="color: #1f2937; font-size: 24px; font-weight: 600; margin: 0 0 12px 0; line-height: 1.3;">
                                                        Hi {{ $user->name }},</h2>
                                                    <p
                                                        style="color: #6b7280; font-size: 16px; line-height: 1.6; margin: 0;">
                                                        Great news! Your funnel has been updated with the latest
                                                        changes. Here's a summary of what's new:
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Funnel Details Cards -->
                                <tr>
                                    <td style="padding: 0 20px;" class="mobile-padding">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            style="background: #ffffff;">
                                            <tr>
                                                <td style="padding: 0 40px 30px 40px;">

                                                    <!-- Goal Card -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                        class="info-card"
                                                        style="background: #f8fafc; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #3b82f6; transition: all 0.3s ease;">
                                                        <tr>
                                                            <td style="padding: 25px;">
                                                                <div
                                                                    style="display: flex; align-items: center; margin-bottom: 12px;">
                                                                    <div
                                                                        style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                                        <svg width="20" height="20" viewBox="0 0 24 24"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M12 2L15.09 8.26L22 9L17 14L18.18 21L12 17.77L5.82 21L7 14L2 9L8.91 8.26L12 2Z"
                                                                                fill="#ffffff" />
                                                                        </svg>
                                                                    </div>
                                                                    <h3
                                                                        style="color: #1f2937; font-size: 18px; font-weight: 600; margin: 0;">
                                                                        Goal</h3>
                                                                </div>
                                                                <p
                                                                    style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0;">
                                                                    {{ $funnel->goal }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <!-- Target Audience Card -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                        class="info-card"
                                                        style="background: #f0fdf4; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #10b981; transition: all 0.3s ease;">
                                                        <tr>
                                                            <td style="padding: 25px;">
                                                                <div
                                                                    style="display: flex; align-items: center; margin-bottom: 12px;">
                                                                    <div
                                                                        style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                                        <svg width="20" height="20" viewBox="0 0 24 24"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                                                                                stroke="#ffffff" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <circle cx="9" cy="7" r="4" stroke="#ffffff"
                                                                                stroke-width="2" stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M23 21V19C23 18.1645 22.7155 17.3541 22.2094 16.7007C21.7033 16.0473 20.9999 15.5902 20.2 15.4"
                                                                                stroke="#ffffff" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M16 3.13C16.8003 3.35031 17.5037 3.80771 18.0098 4.46117C18.5159 5.11463 18.8004 5.92503 18.8004 6.76C18.8004 7.59497 18.5159 8.40537 18.0098 9.05883C17.5037 9.71229 16.8003 10.1697 16 10.39"
                                                                                stroke="#ffffff" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                    </div>
                                                                    <h3
                                                                        style="color: #1f2937; font-size: 18px; font-weight: 600; margin: 0;">
                                                                        Target Audience</h3>
                                                                </div>
                                                                <p
                                                                    style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0;">
                                                                    {{ $funnel->target_audience }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <!-- CTA & Deadline Row -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <!-- CTA Card -->
                                                            <td width="48%" style="padding-right: 2%;"
                                                                class="mobile-stack">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    width="100%" class="info-card"
                                                                    style="background: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b; transition: all 0.3s ease;">
                                                                    <tr>
                                                                        <td style="padding: 25px;">
                                                                            <div
                                                                                style="display: flex; align-items: center; margin-bottom: 12px;">
                                                                                <div
                                                                                    style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                                                    <svg width="20" height="20"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M15 3H6C4.89543 3 4 3.89543 4 5V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V8L15 3Z"
                                                                                            stroke="#ffffff"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round" />
                                                                                        <path d="M15 3V8H20"
                                                                                            stroke="#ffffff"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round" />
                                                                                        <path d="M12 12L8 16L12 20"
                                                                                            stroke="#ffffff"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round" />
                                                                                    </svg>
                                                                                </div>
                                                                                <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 0;"
                                                                                    class="mobile-text-sm">Call to
                                                                                    Action</h3>
                                                                            </div>
                                                                            <p
                                                                                style="color: #4b5563; font-size: 14px; line-height: 1.5; margin: 0; text-transform: capitalize; font-weight: 500;">
                                                                                {{ $funnel->cta }}</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>

                                                            <!-- Deadline Card -->
                                                            <td width="48%" style="padding-left: 2%;"
                                                                class="mobile-stack">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    width="100%" class="info-card"
                                                                    style="background: #fef2f2; border-radius: 12px; border-left: 4px solid #ef4444; transition: all 0.3s ease;">
                                                                    <tr>
                                                                        <td style="padding: 25px;">
                                                                            <div
                                                                                style="display: flex; align-items: center; margin-bottom: 12px;">
                                                                                <div
                                                                                    style="width: 40px; height: 40px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                                                    <svg width="20" height="20"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <rect x="3" y="4" width="18"
                                                                                            height="18" rx="2" ry="2"
                                                                                            stroke="#ffffff"
                                                                                            stroke-width="2" />
                                                                                        <line x1="16" y1="2" x2="16"
                                                                                            y2="6" stroke="#ffffff"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round" />
                                                                                        <line x1="8" y1="2" x2="8"
                                                                                            y2="6" stroke="#ffffff"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round" />
                                                                                        <line x1="3" y1="10" x2="21"
                                                                                            y2="10" stroke="#ffffff"
                                                                                            stroke-width="2" />
                                                                                    </svg>
                                                                                </div>
                                                                                <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 0;"
                                                                                    class="mobile-text-sm">Deadline</h3>
                                                                            </div>
                                                                            <p
                                                                                style="color: #4b5563; font-size: 14px; line-height: 1.5; margin: 0; font-weight: 500;">
                                                                                {{ $funnel->deadline->format('d M Y') }}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- CTA Section -->
                                <tr>
                                    <td style="padding: 0 20px;" class="mobile-padding">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            style="background: #ffffff; border-radius: 0 0 16px 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                                            <tr>
                                                <td style="padding: 30px 40px 40px 40px; text-align: center;">
                                                    <p
                                                        style="color: #6b7280; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                                        Ready to review your updated funnel? Check out the latest
                                                        changes in your dashboard.
                                                    </p>

                                                    <a href="{{ ('/client') }}" class="cta-button"
                                                        style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 8px; font-weight: 600; font-size: 16px; display: inline-block; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3); transition: all 0.2s ease;">
                                                        View Dashboard
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Footer -->
                                <tr>
                                    <td style="padding: 40px 20px 20px 20px;" class="mobile-padding">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <!-- Company info -->
                                            <tr>
                                                <td align="center">
                                                    <p
                                                        style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
                                                        VolvCRM</p>
                                                    <p
                                                        style="color: #9ca3af; font-size: 14px; line-height: 1.5; margin: 0 0 8px 0;">
                                                        Streamline your sales process with intelligent CRM solutions
                                                    </p>
                                                    <p
                                                        style="color: #9ca3af; font-size: 12px; line-height: 1.5; margin: 0;">
                                                        © {{ date('Y') }} VolvCRM. All rights reserved.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>