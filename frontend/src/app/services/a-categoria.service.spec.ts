import { TestBed } from '@angular/core/testing';

import { ACategoriaService } from './a-categoria.service';

describe('ACategoriaService', () => {
  let service: ACategoriaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ACategoriaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
