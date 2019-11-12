@extends('layouts.app')
@section('content')
<div class="container" style="margin-top:15px">
    <style type="text/css">
        #scanner, video {
          width: 100%;
        }
    </style>
    <script type="text/javascript" src="{{ asset('js/jsPretty/jsqrscanner.nocache.js') }}"></script>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <hr>
            <div id="scanner"></div>
            <form id="qrscannerresult" method="POST" action="/scanqr">
                @csrf
                <input id="scannedTextMemo" name="result" style="display:none; width:100%"><hr>
                <button onclick="window.history.back()" class="btn btn-primary btn-block"><i class="fa fa-home" aria-hidden="true"></i> Go to Home</button>
            </form>
        </div>
        <div class="col-md-3"></div>
        <script type="text/javascript">
            function onQRCodeScanned(scannedText){
    	        var scannedTextMemo = document.getElementById("scannedTextMemo");
    	        if(scannedTextMemo){
                    scannedTextMemo.value = scannedText;
                    document.getElementById("qrscannerresult").submit();
    	        }
            }
      
            function provideVideo(){
                var n = navigator;
                if (n.mediaDevices && n.mediaDevices.getUserMedia){
                    return n.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "environment"
                        },
                        audio: false
                    });
                } 
                return Promise.reject('Your browser does not support getUserMedia');
            }

    function provideVideoQQ(){
        return navigator.mediaDevices.enumerateDevices()
        .then(function(devices) {
            var exCameras = [];
            devices.forEach(function(device) {
            if (device.kind === 'videoinput') {
              exCameras.push(device.deviceId)
            }
         });
            
            return Promise.resolve(exCameras);
        }).then(function(ids){
            if(ids.length === 0)
            {
              return Promise.reject('Could not find a webcam');
            }
            
            return navigator.mediaDevices.getUserMedia({
                video: {
                  'optional': [{
                    'sourceId': ids.length === 1 ? ids[0] : ids[1]//this way QQ browser opens the rear camera
                    }]
                }
            });        
        });                
    }
    
    //this function will be called when JsQRScanner is ready to use
    function JsQRScannerReady()
    {
        //create a new scanner passing to it a callback function that will be invoked when
        //the scanner succesfully scan a QR code
        var jbScanner = new JsQRScanner(onQRCodeScanned);
        //var jbScanner = new JsQRScanner(onQRCodeScanned, provideVideo);
        //reduce the size of analyzed image to increase performance on mobile devices
        jbScanner.setSnapImageMaxSize(300);
    	var scannerParentElement = document.getElementById("scanner");
    	if(scannerParentElement)
    	{
    	    //append the jbScanner to an existing DOM element
    		jbScanner.appendTo(scannerParentElement);
    	}        
    }
        </script>
    </div>
</div>
@endsection
        
        


