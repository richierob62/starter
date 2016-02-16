function createPromise() {
  return {
    value: null,
    state: "pending",
    dependencies: []
  };
}

function depend(promise, expression) {
  var result = createPromise();

  if (promise.state === "pending") {
    promise.dependencies.push(function(value) {
      depend(expression(value), function(newValue) {
        fulfil(result, newValue);
        return createPromise();
      })
    });

  } else {
    depend(expression(promise.value), function(newValue) {
      fulfil(result, newValue);
      return createPromise();
    })
  }

  return result;
}

function fulfil(promise, value) {
  if (promise.state !== "pending") {
    throw new Error("Trying to fulfil an already fulfilled promise!");
  } else {
    promise.state = "fulfilled";
    promise.value = value;
    var dependencies = promise.dependencies;
    promise.dependencies = [];
    dependencies.forEach(function(expression) {
      expression(value);
    });
  }
}

