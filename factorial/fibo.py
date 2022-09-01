# store = dict()

def fibonaci(n, memo={}):
    if n in memo:
        return memo[n]
    if n <= 2: return 1
    fib = fibonaci(n - 2, memo) + fibonaci(n - 1, memo)
    memo[n] = fib
    return fib

def fibonaci_improved(n):
    if n <= 2:
        return 1
    f1 = 1
    f2 = 1
    for _ in range(n - 2):
        fib = f1 + f2
        f2 = f1
        f1 = fib      
    return f1
    

tenthousand = fibonaci_improved(10000) 
print(tenthousand) 
