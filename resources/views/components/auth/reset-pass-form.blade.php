<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control mb-3" type="password"/>

                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function ResetPass(){
        let password = document.getElementById('password').value;

        if (password.length == 0) {
            errorToast('New Password Is Required')
        }else{
            let response = await axios.post("/resetPassword", {
                password:password
            })

            if (response.status == 200 && response.data['status'] === 'success') {
                successToast(response.data['message']);
            }else{
                errorToast(response.data['message'])
            }
        }
    }
</script>
