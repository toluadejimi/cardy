<style>

@import url('https://fonts.googleapis.com/css?family=Muli:300,700&display=swap');

* {
  box-sizing: border-box;
}

body {
  background-color: #ebecf0;
  font-family: 'Muli', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  overflow: hidden;
  margin: 0;
}

.container {
  background-color: #fff;
  border-radius: 10px;
  padding: 30px;
  max-width: 1100px;
  text-align: center;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

.code-container {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 40px 0;

}

.code {
  border-radius: 5px;
  font-size: 75px;
  height: 120px;
  width: 100px;
  border: 1px solid #eee;
    outline-width: thin;;
    outline-color: #ddd;
  margin: 1%;
  text-align: center;
  font-weight: 300;
  -moz-appearance: textfield;
  margin-left: 10px;
}

.code::-webkit-outer-spin-button,
.code::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.code:valid {
  border-color: #1DBF73;
box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
}

.info {
  background-color: #ebecf0;
  display: inline-block;
  padding: 10px;
  line-height: 20px;
  max-width: 400px;
  color: #777;
  border-radius: 5px;
}

@media (max-width: 600px) {
  .code-container {
    flex-wrap: wrap;
  }

  .code {
    font-size: 60px;
    height: 80px;
    max-width: 70px;
  }
}


</style>















<!--http://fantacydesigns.com/-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Verify Account| Fantacy Design</title>
  </head>
  <body>
    <div class="container">
      <h2>Verify Your Account</h2>
      <p>@if ($errors->any())
                                                                        <div class="alert alert-danger">
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                    @if (session()->has('message'))
                                                                        <div class="alert alert-success">
                                                                            {{ session()->get('message') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (session()->has('error'))
                                                                        <div class="alert alert-danger">
                                                                            {{ session()->get('error') }}
                                                                        </div>
                                                                    @endif</p>
      <div class="code-container">
        <input type="number" class="code" placeholder="0" min="0" max="9" required>
        <input type="number" class="code" placeholder="0" min="0" max="9" required>
        <input type="number" class="code" placeholder="0" min="0" max="9" required>
        <input type="number" class="code" placeholder="0" min="0" max="9" required>
        <input type="number" class="code" placeholder="0" min="0" max="9" required>
        <input type="number" class="code" placeholder="0" min="0" max="9" required>
      </div>
      <small class="info">
        This is design only. We didn't actually send you an email as we don't have your email, right?
      </small>
    </div>
    <script src="script.js"></script>
  </body>
</html>



<script>

const codes = document.querySelectorAll('.code')

codes[0].focus()

codes.forEach((code, idx) => {
    code.addEventListener('keydown', (e) => {
        if(e.key >= 0 && e.key <=9) {
            codes[idx].value = ''
            setTimeout(() => codes[idx + 1].focus(), 10)
        } else if(e.key === 'Backspace') {
            setTimeout(() => codes[idx - 1].focus(), 10)
        }
    })
})

    </script>