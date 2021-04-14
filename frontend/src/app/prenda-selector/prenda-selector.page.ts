import {COMMA, ENTER} from '@angular/cdk/keycodes';
import {Component,  OnInit, ElementRef, ViewChild} from '@angular/core';
import {FormControl} from '@angular/forms';
import {MatAutocompleteSelectedEvent, MatAutocomplete} from '@angular/material/autocomplete';
import {MatChipInputEvent} from '@angular/material/chips';
import { Router } from '@angular/router';
import {Observable} from 'rxjs';
import {map, startWith} from 'rxjs/operators';
@Component({
  selector: 'app-prenda-selector',
  templateUrl: './prenda-selector.page.html',
  styleUrls: ['./prenda-selector.page.scss'],
})
export class PrendaSelectorPage implements OnInit {
  visible = true;
  selectable = true;
  removable = true;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  prendasCtrl = new FormControl();
  filteredPrendas: Observable<string[]>;
  prendas: string[] = ['Camiseta'];
  prendasSelected: string[];
  allPrendas: string[] = ['Camiseta', 'Pantalón', 'Sudadera', 'Polar', 'Camisa', 'Polo', 'Chaleco', 'Blusón', 'Bata', 'Delantal', 'Pijama', 'Gorra', 'Chaquetilla Cocina'];

  @ViewChild('fruitInput') fruitInput: ElementRef<HTMLInputElement>;
  @ViewChild('auto') matAutocomplete: MatAutocomplete;

  constructor(
    private router: Router
  ) {
    this.filteredPrendas = this.prendasCtrl.valueChanges.pipe(
      startWith(null),
      map((fruit: string | null) => fruit ? this._filter(fruit) : this.allPrendas.slice()));
   }

  ngOnInit() {
  
  }

  add(event: MatChipInputEvent): void {
    const input = event.input;
    const value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.prendas.push(value.trim());
      this.prendasSelected.push(value);
      
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }

    this.prendasCtrl.setValue(null);
  }

  remove(fruit: string): void {
    const index = this.prendas.indexOf(fruit);

    if (index >= 0) {
      this.prendas.splice(index, 1);
    }
  }

  selected(event: MatAutocompleteSelectedEvent): void {
    this.prendas.push(event.option.viewValue);
    this.fruitInput.nativeElement.value = '';
    this.prendasCtrl.setValue(null);
  }

  private _filter(value: string): string[] {
    const filterValue = value.toLowerCase();

    return this.allPrendas.filter(fruit => fruit.toLowerCase().indexOf(filterValue) === 0);
  }

  goToForm(){
    this.router.navigateByUrl("form-page");
  }

}
