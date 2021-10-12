function getTomUlaNumbers()
{
    for(let i = 1; i < 101; i++)
    {
        if(i % 3 == 0 && i % 5 == 0)
            console.log('TomUla');
        else if(i % 3 == 0)
            console.log('Tom');
        else if(i % 5 == 0)
            console.log('Ula');
        else
            console.log(i);
    }
}

getTomUlaNumbers();
