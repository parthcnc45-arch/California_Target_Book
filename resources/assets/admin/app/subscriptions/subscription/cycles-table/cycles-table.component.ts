import { Component, Input, OnInit } from '@angular/core';
import * as moment from 'moment';
import { Cycle } from '../../../../models/cycle';
import { MatDialog } from '@angular/material';
import { EditCycleModalComponent } from './edit-cycle-modal.component';
import { MarkCyclePaidComponent } from './mark-cycle-paid.component';

@Component({
  selector: 'ctb-cycles-table',
  templateUrl: './cycles-table.component.html',
  styleUrls: ['./cycles-table.component.scss']
})
export class CyclesTableComponent implements OnInit {

  @Input() cycles: Array<Cycle>;

  constructor(
      private dialog: MatDialog,
  ) { }

  ngOnInit() {
    console.log(this.cycles);
  }

  cycleStatus(c: Cycle) {
    if (moment().isBetween(c.starts_on, c.ends_on)) return 'active';
    if (moment().isBefore(c.starts_on)) return 'upcoming';
    return 'expired';
  }

  edit(cycle: Cycle) {
    const dialogRef = this.dialog.open(EditCycleModalComponent, {
      data: { cycle },
      width: '360px',
    });

    dialogRef.beforeClose()
        .filter(c => !!c)
        .subscribe((res) => Object.assign(cycle, res.cycle));
  }

  markPaid(cycle: Cycle) {
    const dialogRef = this.dialog.open(MarkCyclePaidComponent, {
      data: { cycle },
      width: '360px',
    });

    dialogRef.beforeClose()
        .filter(c => !!c)
        .subscribe((res) => Object.assign(cycle, res.cycle));
  }

}
