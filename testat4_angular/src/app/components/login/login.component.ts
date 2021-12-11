import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
    public user = "";
    public pw = "";
    public authenticationFailed = false;

    //public loginForm = new FormGroup({
    //   user: new FormControl(''),
    //   pw: new FormControl('')
    //});

    public constructor(private backendService : BackendService, private router : Router) { 
    }

    public ngOnInit(): void {
    }

    public loginUser() {
        if(this.user.length != 0 && this.pw.length != 0) {
            this.backendService.login(this.user, this.pw)
            .then((ok : boolean) => {
                if(ok) {
                    console.log("erfolgreich angemeldet");
                    this.authenticationFailed = false;
                    this.router.navigate(['/friends']);
                } else {
                    console.log(" nicht erfolgreich angemeldet");
                    this.authenticationFailed = true;
                }
            });
        }
    }

    public goToRegister() {
        this.router.navigate(['/register']);
    }
}
