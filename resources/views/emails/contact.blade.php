<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #111827; font-size: 24px; }
        .row { margin-bottom: 15px; }
        .label { font-weight: bold; color: #4b5563; font-size: 14px; display: block; margin-bottom: 5px; }
        .value { color: #111827; font-size: 16px; line-height: 1.5; }
        .footer { margin-top: 30px; border-top: 2px solid #f3f4f6; padding-top: 20px; font-size: 12px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Inquiry</h1>
        </div>
        
        <div class="row">
            <span class="label">From:</span>
            <div class="value">{{ $data['name'] }} ({{ $data['email'] }})</div>
        </div>

        <div class="row">
            <span class="label">Subject:</span>
            <div class="value">{{ $data['subject'] }}</div>
        </div>

        <div class="row">
            <span class="label">Message:</span>
            <div class="value">
                {!! nl2br(e($data['message'])) !!}
            </div>
        </div>

        <div class="footer">
            Received via Leathers.pk Contact Form
        </div>
    </div>
</body>
</html>
