<ons-card>
    <center>
        <div style="width: 200px">
            <form name="frmLogin" method="post">
                <ons-list>

                    <ons-list-item>
                        <div class="left">
                            <img class="list-item__thumbnail" src="https://app.guiafloripa.com.br/wp-content/uploads/2017/08/icone.png">
                        </div>
                        <div class="center">
                            <span class="list-item__title">Acessar</span><span class="list-item__subtitle">utilize sua conta</span>
                        </div>
                    </ons-list-item>
                    <ons-list-item> 
                        <ons-input id="username" name="username" modifier="underbar" type="email" placeholder="Email" float></ons-input>
                    </ons-list-item>
                    <ons-list-item>
                        <ons-input id="password" name="password" modifier="underbar" type="password" placeholder="Password" float></ons-input>
                    </ons-list-item>
                    <ons-list-item>
                        <label class="left">
                            <ons-checkbox name="chkRemember" input-id="check-1"></ons-checkbox>
                        </label>
                        <label for="check-1" class="center">
                            Lembrar de mim
                        </label>
                    </ons-list-item>
                    <ons-list-item> 
                        <ons-button onclick="document.frmLogin.submit()" modifier="large">Entrar</ons-button>
                    </ons-list-item>
                    <ons-list-item> 
                        <a href="#">
                            <small>
                                Recuperar sua Senha
                            </small>
                        </a>
                    </ons-list-item>
                    <ons-list-item> 
                        <a href="#">
                            <ons-icon icon="ion-social-facebook"> Entrar com o Facebook</ons-icon>
                        </a>
                    </ons-list-item>
                </ons-list>
            </form>
        </div>

    </center>
</ons-card>