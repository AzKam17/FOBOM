<!-- ******************************************************************************************************************************
      PAGE DE CONNEXION
     **************************************************************************************************************************** --> 
<div class="login-box">
    <div class="login-logo">
        <img src="img/logo.png" style="width: 75px; height: 75px; margin-left: 19%; margin-bottom: -6%;" alt="Photo de Profil" class="profile-user-img img-responsive" >
        <a href="#"><b>Fobom</b>'S</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Connectez-vous pour demarrer une session</p>

        <form action="index.php?module=connexion&amp;action=connexion" method="post" role='form'>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Nom d'utilisateur" title="Entrez votre nom d'utilisateur" required="" value="" name="login" id="login">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Mot de passe" title="Entrez votre mot de passe" required="" value="" name="pass" id="pass">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" name="connexion" class="btn btn-primary btn-block btn-flat">Log In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div class="row">
    <div class="col-xs-12 text-center">
        <strong>FOBOM's</strong> - Forever Business Owner Bonus Management System <br/> 2018 Copyright@Forever Living S.A.
    </div>
</div>