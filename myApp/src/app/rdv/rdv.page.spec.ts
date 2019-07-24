import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RdvPage } from './rdv.page';

describe('RdvPage', () => {
  let component: RdvPage;
  let fixture: ComponentFixture<RdvPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RdvPage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RdvPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
