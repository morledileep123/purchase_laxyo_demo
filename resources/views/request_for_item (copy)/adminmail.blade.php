<!DOCTYPE html>
<html>
<head>
    <title>New Request For Purchase</title>
</head>
<body>
 <div>
  <h6>Hi Admin {{ $usersmail }} ! <h6></br>
    <p>Manager {{ Auth::user()->name }} Approved  for Item Request On Date : {{date('Y-m-d')}}</p></br>
    <p>Please go through this link : <a href="http://www.laxyo.org" >Here</a> and Check For Further Process</p>

 </div>
</body>
</html>