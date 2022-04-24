
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirm Your Login</title>
    <style>
        body {
               width: 100% !important;
               margin: 0;
               line-height: 1.4;
               background-color: #F2F4F6;
               color: #74787E;
               -webkit-text-size-adjust: none;
               
           }
           .email-body{
               width:600px;
               margin: 0 auto;
           }
           .button {
               background-color: #b70f1b !important;
               padding: 10px 0px;
               display: block;
               color: #FFF !important;
               text-align: center;
               width: 100% !important;
               text-decoration: none;
               border-radius: 3px;
               box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
               -webkit-text-size-adjust: none;
           }
   
           /*Media Queries ------------------------------ */
   
           @media only screen and (max-width: 600px) {
               .email-body{
                   width: 100% !important;
               }
           }
   
       </style>
</head>
<body>



 <table width="600" border="0" cellspacing="0" cellpadding="0" class="email-body">
    <tbody>
      <tr>
        <td bgcolor="#ffffff">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    
        <p>Hi {{ $staff_firstname }}</p>
<p style="text-align: left;">
    You received this email because you have enabled two factor authentication in your account.
    <br />
    Use the following code to confirm your login:</p>
    
    <p style="text-align: left;">
        <span style="font-size: 18pt;">
            <strong>{{ $two_factor_auth_code }}<br /><br /></strong>
            <span style="font-size: 12pt;">{{ $email_signature }}</span>
            <strong><br /><br /><br /><br /></strong></span></p>


    </tbody>
          </table>
        </td>
      </tr>
    </tbody>
 </table>

</body>
</html>