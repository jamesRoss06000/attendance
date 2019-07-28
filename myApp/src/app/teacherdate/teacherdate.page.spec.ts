import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TeacherdatePage } from './teacherdate.page';

describe('TeacherdatePage', () => {
  let component: TeacherdatePage;
  let fixture: ComponentFixture<TeacherdatePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TeacherdatePage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TeacherdatePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
