<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .label { font-weight: bold; color: #666; font-size: 12px; text-transform: uppercase; }
        .content { background: #fff; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
            <p>You have received a new message via the Vertex blog.</p>
        </div>

        <div class="content">
            <p><span class="label">Name:</span><br> {{ $data['name'] }}</p>
            <p><span class="label">Email:</span><br> <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
            
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            
            <p><span class="label">Message:</span></p>
            <p style="white-space: pre-wrap;">{{ $data['message'] }}</p>
        </div>
    </div>
</body>
</html>