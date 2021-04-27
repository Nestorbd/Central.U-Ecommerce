import { TestBed } from '@angular/core/testing';

import { CTarifaService } from './t-categoria.service';

describe('CTarifaService', () => {
  let service: CTarifaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CTarifaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
