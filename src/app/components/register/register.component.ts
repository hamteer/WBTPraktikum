import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';

@Component({
    selector: 'app-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
    public username = "";
    public password = "";
    public confirmPassword = "";
    // for disabling and showing errors 
    // Username
    public usernameOk = false;
    public usernameTooShort = true;
    public usernameExists = false;
    public pristineUser = true;
    // Password
    public passwordOk = false;
    public passwordTooShort = true;
    public pristinePassword = true;
    // Password confirmation
    public confirmationOk = true;

    public constructor(private backendService: BackendService, private router : Router) {
    }

    public ngOnInit(): void {
    }

    public checkUsername() {
        this.pristineUser = false;
        if (this.username.length < 3) {
            this.usernameTooShort = true;
            this.usernameExists = false;
        } else {
            this.usernameTooShort = false;
            this.backendService.userExists(this.username)
                .then((ok: boolean) => {
                    if (ok) {
                        this.usernameExists = true;
                    } else {
                        this.usernameExists = false;
                        // enable register button
                        if (!this.usernameExists && !this.usernameTooShort) {
                            this.usernameOk = true;
                        } else {
                            this.usernameOk = false;
                        }
                    }
                });
        }


    }

    public checkPassword() {
        this.pristinePassword = false;
        if (this.password.length < 8) {
            this.passwordTooShort = true;
        } else {
            this.passwordTooShort = false;
        }

        if (this.confirmPassword.length != 0) {
            this.checkConfirmation();
        }
    }

    public checkConfirmation() {
        if (this.password.match(this.confirmPassword) != null && this.password.length == this.confirmPassword.length) {
            this.confirmationOk = true;
            this.passwordOk = true;
        } else {
            this.confirmationOk = false;
            this.passwordOk = false;
        }
    }

    public registerUser() {
        if(this.usernameOk && this.passwordOk) {
            this.backendService.register(this.username, this.password)
            .then((ok: boolean) => {
                if(ok) {
                    console.log("successful registration");
                    this.router.navigate(['/friends']);
                } else {
                    console.log("registration failed!");
                }
            });
        }

    }

    public backToLogin() {
        this.router.navigate(['/login']);
    }
}
