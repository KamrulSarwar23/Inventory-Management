<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>Your Email</label>
                    <input id="email" placeholder="Email" class="form-control mb-3" type="email"/>
                    <label>4 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text"/>
                    <br/>
                    <button onclick="VerifyOtp()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function VerifyOtp(){
        let email = document.getElementById('email').value;
        let otp = document.getElementById('otp').value;
       
        if (otp.length == 0) {
            errorToast('Otp Is Required');
        }else{
            let response = await axios.post("/verifyOTP", {
                email:email,
                otp:otp
            })

            if (response.status === 200 && response.data['status'] === 'success' ) {
                successToast(response.data['message']);
                window.location.href = "/resetPassword";
            }else{
                errorToast(response.data['message']);
            }
        }


    }
</script>