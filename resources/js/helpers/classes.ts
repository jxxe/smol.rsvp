type ClassesObject = { [key: string]: boolean };

export function classes(baseClasses: string|string[], conditionalClasses: ClassesObject): string {
    let toApply = new Set<string>();
    if(typeof baseClasses !== 'string') baseClasses = baseClasses.join(' ');
    conditionalClasses[baseClasses] = true;

    for(const classes in conditionalClasses) {
        if(conditionalClasses[classes]) {
            classes.trim().split(' ').forEach(c => toApply.add(c));
        }
    }

    return Array.from(toApply).join(' ');
}