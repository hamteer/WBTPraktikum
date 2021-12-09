import { Component, OnInit } from '@angular/core';
import { ContextService } from 'src/app/services/context.service';
import { IntervalService } from 'src/app/services/interval.service';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
  styleUrls: ['./logout.component.css']
})
export class LogoutComponent implements OnInit {

  constructor(private contextService : ContextService, private intervalService : IntervalService) { }

  ngOnInit(): void {
    this.contextService.currentChatUsername = "";
    this.contextService.loggedInUsername = "";
    this.intervalService.clearIntervals();
  }

}
