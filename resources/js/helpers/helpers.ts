// https://stackoverflow.com/a/51567564
export function isHexLight(hexCode: string): boolean {
    hexCode = hexCode.replace('#', '');
    const r = parseInt(hexCode.substring(0, 0 + 2), 16);
    const g = parseInt(hexCode.substring(2, 2 + 2), 16);
    const b = parseInt(hexCode.substring(4, 4 + 2), 16);
    const brightness = (r*299 + g*587 + b*114) / 1000;
    return brightness > 155;
}