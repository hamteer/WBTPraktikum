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
    public usernameExists = false;
    // Password
    public passwordOk = false;
    // Password confirmation
    public confirmationOk = true;

    public constructor(private backendService: BackendService, private router : Router) {
    }

    public ngOnInit(): void {
    }

    public checkUsername() {
        this.backendService.userExists(this.username)
            .then((ok: boolean) => {
                if (ok) {
                    // User already exists
                    this.usernameOk = false;
                    this.usernameExists = true;
                } else {
                    // User dont exists, check username length
                    this.usernameExists = false;
                    if (this.username.length < 3) {
                        this.usernameOk = false;
                    } else {
                        this.usernameOk = true;
                    }
                }
            });
    }

    public checkPassword() {
        if (this.confirmPassword.length > 8) {
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
        } else {
            console.log("registration failed, check input");            
        }

    }

    public backToLogin() {
        this.router.navigate(['/login']);
    }
}
