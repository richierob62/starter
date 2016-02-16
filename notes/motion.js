stylingFunction(index) {
    let{deltaX, deltaY} = finalDeltaPositions(index);
    return {
        width: CHILD_BUTTON_DIAM,
        height: CHILD_BUTTON_DIAM,
        left: spring(M_X + deltaX, [Stiffness, damping]),
        top: spring(M_Y - deltaY, [Stiffness, damping])
    };
}

render() {
    return (
        <div>
            { items.map( (item, index) => {
                let style = this.stylingFunction(index);
                return (
                    <Motion style={interpolated} key={index}>
                        { styleIterator(interpolated) }
                    </Motion>
                );
            })}
        </div>
    );
}

styleIterator( {width, height, top, left} ) {
    return (
        <div    className="child-button"
                style={{
                    width: width,
                    height: height,
                    top: top,
                    left: left
                }}>

        </div>
    );
}
