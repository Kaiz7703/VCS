def binary_search(arr, target):
    left = 0
    right = len(arr) - 1

    while left <= right:
        mid = (left + right) // 2 

        if arr[mid] == target:
            return mid  
        elif arr[mid] < target:
            left = mid + 1  
        else:
            right = mid - 1  

    return -1 

arr = list(map(int, input("Nhập danh sách số nguyên: ").split()))

target = int(input("Nhập số cần tìm: "))

result = binary_search(arr, target)

if result != -1:
    print(f"Phần tử {target} được tìm thấy tại vị trí {result}")
else:
    print(f"Phần tử {target} không tồn tại trong danh sách")