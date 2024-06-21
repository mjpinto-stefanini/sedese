
export const isCpf = (cpf) => {
    const validar = cpf => checkAll(prepare(cpf))

    const notDig = i => !['.', '-', ' '].includes(i)
    const prepare = cpf => cpf.trim().split('').filter(notDig).map(Number)
    const is11Len = cpf => cpf.length === 11
    const notAllEquals = cpf => !cpf.every(i => cpf[0] === i)
    const onlyNum = cpf => cpf.every(i => !isNaN(i))

    const calcDig = limit => (a, i, idx) => a + i * ((limit + 1) - idx)
    const somaDig = (cpf, limit) => cpf.slice(0, limit).reduce(calcDig(limit), 0)
    const resto11 = somaDig => 11 - (somaDig % 11)
    const zero1011 = resto11 => [10, 11].includes(resto11) ? 0 : resto11

    const getDV = (cpf, limit) => zero1011(resto11(somaDig(cpf, limit)))
    const verDig = pos => cpf => getDV(cpf, pos) === cpf[pos]

    const checks = [is11Len, notAllEquals, onlyNum, verDig(9), verDig(10)]
    const checkAll = cpf => checks.map(f => f(cpf)).every(r => !!r)
    const resultado = validar(cpf) || "Formato de CPF inválido";

    return resultado;
}

export const isEmail = (value) => {
    return ((value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido");
}

export const isRequired = (value) => {
    return !!value || "Campo obrigatório";
}
export const onlyLetter = (e) => {
    let char = String.fromCharCode(e.keyCode);
    if (/^[A-Za-z\s]+$/.test(char)) {
        return true;
    } else {
        e.preventDefault();
    }
}

export const isEmpty = (input) => {
    if (input === '' || input === null) {
        return false;
    }
    return true;
}

export const isCellPhoneNumber = (value) => {
    if(value){
        return (
            (value && /^\(\d{2}\) \d \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres"
        );
    }
}

export const isPhoneNumber = (value) => {
    if(value){
        return (
            (value && /^\(\d{2}\) \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres"
        );
    }
}

export const isNumber = (value) => {
    if(value){
        return (
            (value && /^\d+$/.test(value)) || "Somente números"
        );
    }
}

export const isMatch = (value1, value2, message) => {
    if (value1 !== value2) {
        return message;
    }
    return true;
}

export const isLetter = (value) => {
    if(value){
        return (
            (value && /^[a-zA-ZÀ-ÿ ]+$/.test(value)) || "Nome deve conter apenas letras"
        );
    }
}