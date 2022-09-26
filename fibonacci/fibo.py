# store = dict()

def fibonaci(n, memo={}):
    if n in memo:
        return memo[n]
    if n == 0:
        return 0
    if 1 <= n <= 2:
        return 1
    fib = fibonaci(n - 2, memo) + fibonaci(n - 1, memo)
    memo[n] = fib
    return fib

def fibonaci_improved(n):
    if n == 0:
        return 0
    if 1 <= n <= 2:
        return 1
    f1 = 1
    f2 = 1
    for _ in range(2, n):
        fib = f1 + f2
        f2 = f1
        f1 = fib
    return fib


tenthousand = fibonaci_improved(10000)
print(tenthousand)
