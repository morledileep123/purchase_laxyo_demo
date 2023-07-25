<!DOCTYPE html>
<html>
<head>
    <title>New Request For Purchase</title>
</head>
<body>
 <div>
  <h1>Hi {{ $uname }} ! <h1></br>
    <h2>User Requested Items for this Side {{ $siteName }} </h2></br>
    <h2> Item On Date : {{ $requestDate }}</h2></br>
    <h2>Please go through this link : <a href="http://127.0.0.1:8000/request_for_item" >Here</a></h2>
    {{-- <h2>Please go through this link : <a href="http://purchase.laxyo.org/request_for_item" >Here</a></h2> --}}

 </div>
</body>
</html>