import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { StudentdatePage } from './studentdate.page';

describe('StudentdatePage', () => {
  let component: StudentdatePage;
  let fixture: ComponentFixture<StudentdatePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StudentdatePage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StudentdatePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
