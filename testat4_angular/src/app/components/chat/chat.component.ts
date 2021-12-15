import { Component, OnInit } from '@angular/core';
import { AfterViewChecked, ElementRef, ViewChild } from '@angular/core';
import { BackendService } from 'src/app/services/backend.service';
import { IntervalService } from 'src/app/services/interval.service';
import { ContextService } from 'src/app/services/context.service';
import { Message } from 'src/app/models/Message';

import { User } from 'src/app/models/User';
import { Router } from '@angular/router';
import { Time } from '@angular/common';

@Component({
    selector: 'app-chat',
    templateUrl: './chat.component.html',
    styleUrls: ['./chat.component.css']
})

export class ChatComponent implements OnInit, AfterViewChecked {
    // DIV für Nachrichten (s. Template) als Kind-Element für Aufrufe (s. scrollToBottom()) nutzen
    @ViewChild('messagesDiv') private myScrollContainer: ElementRef;

    public myUser!: User | null;
    public otherUser!: User | null;
    public otherUserName: string = "Franz";
    public msg!: string;
    public msgArr: Message[] = [];
    public layout!: string;

    public constructor(private backendService: BackendService, private router: Router, private intervalService: IntervalService, private contextService: ContextService) {
        this.myScrollContainer = new ElementRef(null);
    }

    public ngAfterViewChecked() {
        this.scrollToBottom();
    }

    /**
     * Setzt in der Nachrichtenliste die Scrollposition ("scrollTop") auf die DIV-Größe ("scrollHeight"). Dies bewirkt ein 
     * Scrollen ans Ende.
     */
    private scrollToBottom(): void {
        try {
            this.myScrollContainer.nativeElement.scrollTop = this.myScrollContainer.nativeElement.scrollHeight;
        } catch (err) {
        }
    }

    public ngOnInit(): void {
        this.scrollToBottom();
        this.otherUserName = this.contextService.currentChatUsername;

        this.backendService.loadCurrentUser()
            .then((user: any) => {
                if (user == null) {
                    console.log('user is null, something failed')
                    this.router.navigate(['/login']);
                } else {
                    this.myUser = user;
                    this.layout = user.layout ? user.layout:'oneliner';
                    console.log(this.layout);

                }
            });

        this.backendService.loadUser(this.otherUserName)
            .then((user: any) => {
                if (user == null) {
                    console.log('user does not exist')
                    alert('user does not exist')
                } else {
                    this.otherUser = user;
                }
            });

        this.update();
    }


    public update() {
        this.intervalService.setInterval("chat", () => {
            console.log('test');
            this.backendService.listMessages(this.otherUserName)
                .then((messages: any[]) => {
                    this.msgArr = messages;
                    console.log(messages);
                })
        });
    }

    public stopIntervall() {
        this.intervalService.clearIntervals();
    }

    public send() {

        this.backendService.sendMessage(this.otherUserName, this.msg)
            .then((ok: boolean) => {
                console.log(this.msg);
                console.log(this.otherUserName);

                if (ok) {
                    console.log('Nachricht erfolgreich gesendet');
                } else {
                    console.log('Nachricht senden fehlgeschlagen');
                }
            });
    }

    public goBack(): void {
        this.stopIntervall();
        this.router.navigate(['/friends']);
    }

    public timeConverter(time: number): string {
        const unixTime = time;
        const date = new Date(time)
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let seconds = date.getSeconds();
        return hours + ":" + minutes + ":" + seconds;
    }

    public goToProfile() {
        this.stopIntervall();
        this.router.navigate(['/profile']);
    }

    public removeFriend() {
        if (confirm("Are you sure you want to delete this friend")) {
            this.backendService.removeFriend(this.otherUserName)
                .then((ok: boolean) => {
                    if (ok) {
                        this.goBack();
                        alert('friend has been removed');
                    } else {
                        alert('deleting friend failed')
                    }
                });

        }
    }

}
