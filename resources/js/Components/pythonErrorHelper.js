/**
 * Parses Python error messages and returns a friendly explanation.
 */
export function explainPythonError(errorMessage) {
    if (!errorMessage) return null;

    const msg = errorMessage.toString();

    // Extract the error type and line number
    const lineMatch = msg.match(/line (\d+)/);
    const line = lineMatch ? lineMatch[1] : null;
    const lineInfo = line ? ` (linija ${line})` : '';

    // SyntaxError
    if (msg.includes('SyntaxError')) {
        if (msg.includes('EOL while scanning string')) {
            return `Greska u pisanju${lineInfo}: Zaboravio/la si da zatvoriš navodnike. Svaki tekst mora imati navodnike i na početku i na kraju: 'tekst'`;
        }
        if (msg.includes('unexpected EOF')) {
            return `Greska u pisanju${lineInfo}: Program se završio naglo. Verovatno fali zagrada ) ili : na kraju linije.`;
        }
        if (msg.includes('invalid syntax')) {
            return `Greska u pisanju${lineInfo}: Python ne razume ovu liniju. Proveri da li su svi navodnici, zagrade i dvotačke na mestu.`;
        }
        if (msg.includes('expected an indented block')) {
            return `Greska u pisanju${lineInfo}: Posle if, elif, else, for ili while treba da uvučeš sledeću liniju sa 4 razmaka (ili Tab).`;
        }
        if (msg.includes('unexpected indent')) {
            return `Greska u pisanju${lineInfo}: Ova linija je previše uvučena. Proveri razmake na početku linije.`;
        }
        return `Greska u pisanju${lineInfo}: Python ne razume tvoj kod. Proveri navodnike, zagrade i dvotačke.`;
    }

    // NameError
    if (msg.includes('NameError')) {
        const nameMatch = msg.match(/name '(\w+)' is not defined/);
        if (nameMatch) {
            return `Nepoznato ime${lineInfo}: Python ne zna šta je "${nameMatch[1]}". Da li si zaboravio/la navodnike? Ako je tekst, treba: '${nameMatch[1]}'. Ako je promenljiva, proveri da li si je prethodno napravio/la.`;
        }
        return `Nepoznato ime${lineInfo}: Koristiš nešto što Python ne prepoznaje. Proveri da li je sve ispravno napisano.`;
    }

    // TypeError
    if (msg.includes('TypeError')) {
        if (msg.includes('can only concatenate str')) {
            return `Greska sa tipom${lineInfo}: Pokušavaš da spojiš tekst i broj. Koristi str() da pretvoriš broj u tekst, ili koristi zareze u print(). Primer: print('Imam', 12, 'godina')`;
        }
        if (msg.includes('unsupported operand type')) {
            return `Greska sa tipom${lineInfo}: Pokušavaš da računaš sa tekstom umesto sa brojem. Koristi int() ili float() da pretvoriš tekst u broj.`;
        }
        return `Greska sa tipom${lineInfo}: Mešaš različite tipove podataka (npr. tekst i broj). Proveri da li koristiš int(), float() ili str() gde treba.`;
    }

    // ValueError
    if (msg.includes('ValueError')) {
        if (msg.includes('invalid literal for int()')) {
            return `Pogrešna vrednost${lineInfo}: Pokušavaš da pretvoriš nešto u broj, ali to nije broj. Proveri da li unosiš samo cifre (bez slova ili razmaka).`;
        }
        if (msg.includes('could not convert string to float')) {
            return `Pogrešna vrednost${lineInfo}: Uneseni tekst ne može da se pretvori u decimalni broj. Koristi tačku umesto zareza za decimale (npr. 3.14, ne 3,14).`;
        }
        return `Pogrešna vrednost${lineInfo}: Podatak koji si uneo/la nije u ispravnom formatu.`;
    }

    // ZeroDivisionError
    if (msg.includes('ZeroDivisionError')) {
        return `Deljenje nulom${lineInfo}: Ne možeš da deliš sa nulom! Proveri da drugi broj nije 0.`;
    }

    // IndexError
    if (msg.includes('IndexError')) {
        return `Greska sa indeksom${lineInfo}: Pokušavaš da pristupiš elementu koji ne postoji. Npr. ako lista ima 3 elementa, najveći indeks je 2 (jer se broji od 0).`;
    }

    // IndentationError
    if (msg.includes('IndentationError')) {
        return `Greska sa uvlačenjem${lineInfo}: Razmaci na početku linije nisu ispravni. Posle if, for, while koristi tacno 4 razmaka za uvlačenje.`;
    }

    // EOFError (from input cancel)
    if (msg.includes('EOFError')) {
        return `Unos je otkazan. Klikni ponovo Run i unesi podatak kada se pojavi prozor.`;
    }

    // KeyError
    if (msg.includes('KeyError')) {
        return `Ključ ne postoji${lineInfo}: Pokušavaš da pristupis elementu koji ne postoji u rečniku.`;
    }

    // AttributeError
    if (msg.includes('AttributeError')) {
        return `Greska sa atributom${lineInfo}: Pozivuješ funkciju ili svojstvo koje ne postoji na ovom objektu. Proveri da li si ispravno napisao/la naziv.`;
    }

    // ModuleNotFoundError
    if (msg.includes('ModuleNotFoundError')) {
        const modMatch = msg.match(/No module named '(\w+)'/);
        if (modMatch) {
            return `Modul "${modMatch[1]}" ne postoji. Ovaj modul nije dostupan u pretraživaču. Koristi samo standardne Python module.`;
        }
    }

    // Generic fallback - still show the original error
    return null;
}
